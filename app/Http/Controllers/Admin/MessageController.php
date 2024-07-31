<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Massage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    //
    public function index()
    {
        $massage = Massage::all();
        return view('admin.page.massage.index', compact('massage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
        ]);

        Massage::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);
        $this->sendMessageToMailAdmin($request);
        return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim.');
    }


    private function sendMessageToMailAdmin($request)
    {
        $DataUser = User::where('role_as', 1)->get();
        $details = [
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ];
        foreach ($DataUser as $key => $value) {
            Mail::send('emails.contact', $details, function($message) use ($value, $request) {
                $message->to($value->email)->subject('Pesan Dari ['.$request->nama.']');
            });
        }
        
    }
}
