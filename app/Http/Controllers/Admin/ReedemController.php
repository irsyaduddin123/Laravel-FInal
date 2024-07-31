<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reedem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReedemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reedem = Reedem::all();
        return view('admin.page.reedem.index', compact('reedem'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'code' => 'required|unique:reedemcodes,code|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'stok_code' => 'required|integer',
        ]);

        // $validator = Validator::make($request->all(), [
        //     'code' => 'required|unique:reedem',
        //     'discount' => 'required|numeric',
        // ]);

        // if ($validator->fails()) {
        //     Alert::toast($validator->messages()->all(), 'error');
        //     return back()->withInput();
        // }


        $reedem = new Reedem;
        $reedem->code = $request->code;
        $reedem->discount_percentage = $request->discount_percentage / 100;
        $reedem->stok_code = $request->stok_code;
        $reedem->save();
        return redirect()->route('admin.reedem.index')->with('success', 'Reedem code created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'code' => 'required|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'stok_code' => 'required|integer',
        ]);

        $reedem = Reedem::findOrFail($id);
        $reedem->code = $request->code;
        $reedem->discount_percentage = $request->discount_percentage / 100;
        $reedem->stok_code = $request->stok_code;
        $reedem->update();
        return redirect()->route('admin.reedem.index')->with('success', 'Reedem code updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $redeem = Reedem::findOrFail($id);
        $redeem->delete();
        return redirect()->route('admin.reedem.index')->with('success', 'Reedem code deleted successfully');
    }
}
