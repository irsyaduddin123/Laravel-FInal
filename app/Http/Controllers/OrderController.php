<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Ordersdetail;
use App\Models\Reedem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function settlement($order_code)
    {
        $order = Order::where('order_code', $order_code)->first();
        if ($order) {
            return redirect('/checkout/' . $order->id);
        } else {
            abort(404);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            // Mengambil satu instance Order dengan menggunakan `first()`
            $order = Order::where('order_code', $request->order_id)->first();
            if ($order) {
                if ($request->transaction_status == 'settlement') {
                    $order->status = 'Paid';
                } elseif ($request->transaction_status == 'pending') {
                    $order->status = 'Unpaid';
                } elseif ($request->transaction_status == 'expire') {
                    $order->status = 'Expire';
                    $code = Reedem::where('code', $order->reedem_code)->first();
                    if ($code) {
                        $code->stok_code += 1;
                        $code->update();
                    }
                }
                $this->saveDataCallBack($request, $request->order_id);
                $order->save(); // Menggunakan `save` untuk menyimpan perubahan
                return response()->json(['status' => 'ok'], 200);
            } else {
                // Jika order tidak ditemukan, berikan respons yang sesuai
                return response()->json(['status' => 'failed'], 400);
            }
        } else {
            // Jika signature key tidak sesuai, berikan respons yang sesuai
            return response()->json(['status' => 'ok'], 200);
        }
    }

    public function saveDataCallBack($request, $order_id)
    {
        $order = Order::where('order_code', $order_id)->first();
        $getData = null;
        if ($request->payment_type == "bank_transfer") {
            $dataBank = json_encode($request->va_numbers[0]);
            if (isset($dataBank)) {
                $getData = [
                    [
                        'label' => 'Bank',
                        'value' => strtoupper(json_decode($dataBank)->bank),
                    ],
                    [
                        'label' => 'No Rekening',
                        'value' => json_decode($dataBank)->va_number,
                    ],
                    [
                        'label' => 'Waktu Pembayaran',
                        'value' => ($request->status_code == '200') ? $request->settlement_time : $request->transaction_time,
                    ],
                ];
            } elseif (isset($request->permata_va_number)) {
                $getData = [
                    [
                        'label' => 'Bank',
                        'value' => 'Permata VA',
                    ],
                    [
                        'label' => 'No Rekening',
                        'value' => $request->permata_va_number,
                    ],
                    [
                        'label' => 'Waktu Pembayaran',
                        'value' => ($request->status_code == '200') ? $request->settlement_time : $request->transaction_time,
                    ],
                ];
            }
        } elseif ($request->payment_type == "echannel") {
            $getData = [
                [
                    'label' => 'Bank',
                    'value' => 'Mandiri Bill',
                ],
                [
                    'label' => 'Biller Code',
                    'value' => $request->biller_code,
                ],
                [
                    'label' => 'Bill Key',
                    'value' => $request->bill_key,
                ],
                [
                    'label' => 'Waktu Pembayaran',
                    'value' => ($request->status_code == '200') ? $request->settlement_time : $request->transaction_time,
                ],
            ];
        } elseif ($request->payment_type == "qris") {
            $getData = [
                [
                    'label' => 'QRIS',
                    'value' => (($request->acquirer != null) ? ucwords($request->acquirer) : number_format($request->gross_amount, 0)),
                ],
                [
                    'label' => 'Transaksi ID',
                    'value' => $request->transaction_id,
                ],
                [
                    'label' => 'Wallet Payment',
                    'value' => (($request->issuer != null) ? ucwords($request->issuer) : 'Pedding'),
                ],
                [
                    'label' => 'Waktu Pembayaran',
                    'value' => ($request->status_code == '200') ? $request->settlement_time : $request->transaction_time,
                ],
            ];

            if ($request->shopeepay_reference_number) {
                $getData[] = [
                    'label' => 'ShopeePay Reference Number',
                    'value' => $request->shopeepay_reference_number,
                ];
            }
        } elseif ($request->payment_type == "cstore") {
            $getData = [
                [
                    'label' => 'Mini Market',
                    'value' => (($request->store != null) ? ucwords($request->store) : number_format($request->gross_amount, 0)),
                ],
                [
                    'label' => 'No Pembayaran',
                    'value' => $request->payment_code,
                ],
                [
                    'label' => 'Waktu Pembayaran',
                    'value' => ($request->status_code == '200') ? $request->settlement_time : $request->transaction_time,
                ],
            ];
        };

        $order->data = json_encode($getData);
        $order->save();
    }

    public function payment($order_id)
    {
        $snapToken = '';
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->where('id', $order_id)->first();
        $orderDetail = Ordersdetail::where('order_id', $order_id)->get();
        $code = Reedem::where('code', $order->reedem_code)->first();

        if ($code && $order->snaptoken == null) {
            if ($code->stok_code <= 0) {
                $total_price_back = 0;
                foreach ($orderDetail as $key => $value) {
                    $total_price_back += ($value->qty * $value->price);
                };
                $order->reedem_code = null;
                $order->discount_percentage = null;
                $order->discount_amount = null;
                $order->total_price = $total_price_back;
                $order->save();
                // Jika stok kode habis, kembalikan pesan kesalahan
                return redirect()->back()->with('message', [
                    'pesan' => 'Redeem code "' . $code->code . '" is out of stock.',
                    'type' => 'danger'
                ]);
            }
        }
        // Generate order_code by combining order id and current time
        $order_code = 'GEARGEEK_' . $user_id . time();
        // Save order_code to the database
        if ($order->order_code == null) {
            $order->order_code = $order_code;
            $order->save();
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->order_code,
                'gross_amount' => $order->total_price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => $order->phone,
            ),
            // "callbacks" => array(
            //     "finish" => "https://example.com/",
            //     "error" => "https://example1.com",
            // )
        );

        if ($order->snaptoken == null) {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->snaptoken = $snapToken;
            $order->save();

            $code = Reedem::where('code', $order->reedem_code)->first();
            if ($code) {
                $code->stok_code -= 1;
                $code->update();
            }
            session()->flash('paynow', true);
        } else {
            $snapToken = $order->snaptoken;
        }
        return view('frontend.paynow', compact('snapToken', 'order', 'orderDetail'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|integer',
        ]);

        // Ambil ID pengguna yang sedang login
        $userId = Auth::user()->id;

        $address = Address::where('user_id', $userId)->where('id', $request->address_id)->first();
        if (!$address) {
            return redirect()->back()->with('error', 'Address not found');
        }

        // Ambil item keranjang belanja pengguna
        $cartItems = Cart::where('user_id', $userId)->get();

        // Pengecekan stok
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product_qty > $cartItem->product->stok) {
                return redirect()->back()->with('error', 'Quantity of ' . $cartItem->product->name .  ' exceeds available stock. Current stock: ' . $cartItem->product->stok);
            }
        }

        // Buat pesanan baru
        $order = new Order;
        $order->user_id = $userId;
        $order->nameaddress = $address->name;
        $order->address = $address->address;
        $order->phone = $address->phone;
        $order->total_price = 0;
        $order->save();

        // Simpan item pesanan
        foreach ($cartItems as $cartItem) {
            $orderItem = new Ordersdetail;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->qty = $cartItem->product_qty;
            $orderItem->price = $cartItem->product->price; // Harga produk saat ini
            $orderItem->save();

            // Kurangi stok produk
            $cartItem->product->update([
                'stok' => $cartItem->product->stok - $cartItem->product_qty
            ]);

            // Hapus item dari keranjang belanja
            $cartItem->delete();
        }

        $orderDetail = Ordersdetail::where('order_id', $order->id)->get();
        $total_price_back = 0;
        foreach ($orderDetail as $key => $value) {
            $total_price_back += ($value->qty * $value->price);
        }
        $order->total_price = $total_price_back;
        $order->save();

        // Redirect ke halaman pembayaran dengan pesan sukses
        return redirect('checkout/' . $order->id)->with('message', 'Please Continue Payment');
    }


    public function orderDetail($order_id)
    {
        $order = Order::findOrFail($order_id); // Menggunakan findOrFail untuk memunculkan 404 jika tidak ditemukan
        $orderItems = Ordersdetail::where('order_id', $order_id)->get();
        return view('frontend.checkout', compact('order', 'orderItems'));
    }


    public function paymentreedem(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $reedemCode = $request->reedem_code;

        $code = Reedem::where('code', $reedemCode)->first();
        if ($code) {
            if ($code->stok_code <= 0) {
                // Jika stok kode habis, kembalikan pesan kesalahan
                return redirect()->back()->with('message', [
                    'pesan' => 'Redeem code is out of stock.',
                    'type' => 'danger'
                ]);
            }

            if ($order->reedem_code) {
                // Mengembalikan diskon jika kode redeem sebelumnya sudah digunakan
                $previousCode = Reedem::where('code', $order->reedem_code)->first();
                if ($previousCode) {
                    $order->total_price += $order->discount_amount;
                    $previousCode->stok_code += 1;
                    $previousCode->update();
                }
            }

            // Mengurangi stok kode jika valid dan tersedia
            // $code->stok_code -= 1;
            // $code->update();

            $discountAmount = $order->total_price * $code->discount_percentage; // Persentase diskon diubah ke desimal
            $order->total_price -= $discountAmount;
            $order->discount_amount = $discountAmount;
            $order->reedem_code = $reedemCode;
            $order->discount_percentage = $code->discount_percentage;

            $order->update();

            return redirect()->back()->with('message', [
                'pesan' => 'Redeem code successfully applied.',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with('message', [
                'pesan' => 'Redeem code not validated.',
                'type' => 'danger'
            ]);
        }
    }

    public function removerPayment($order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->reedem_code) {
            // Mengembalikan total harga pesanan sebelum diskon
            $order->total_price += $order->discount_amount;

            // Menghapus data terkait diskon
            $order->discount_amount = null;
            $order->reedem_code = null;
            $order->discount_percentage = null;

            $order->update();

            return redirect()->back()->with('message', [
                'pesan' => 'Redeem Code successfully removed.',
                'type' => 'warning'
            ]);
        } else {
            return redirect()->back()->with('message', [
                'pesan' => 'No redeem code found to remove.',
                'type' => 'danger'
            ]);
        }
    }

    public function ordersCart()
    {
        $order = Order::where('status', 'Paid')->get();
        $cart = Cart::all();
        return view('admin.page.orders.index', compact('order', 'cart'));
    }
}
