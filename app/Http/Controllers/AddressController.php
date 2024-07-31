<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('frontend.address.index', compact('addresses'));
    }

    public function create()
    {
        // return view('frontend.address.create');
        return redirect('/home')->with('tabs_home', [
            'type' => 'address'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        Address::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('tabs_home', [
            'type' => 'address',
            'title' => 'Add New Address',
            'text' => 'Successfully Add New Addresses',
            'icon' => 'success',
        ]);
    }

    public function edit($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->findOrFail($id);
        return view('frontend.address.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $address = Address::where('user_id', Auth::user()->id)->findOrFail($id);
        $address->update($validated);
        return redirect('/home')->with('tabs_home', [
            'type' => 'address',
            'title' => 'Update Address',
            'text' => 'Successfully Update Addresses '.$request->name,
            'icon' => 'success',
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $address = Address::where('user_id', Auth::user()->id)->findOrFail($id);
        $address->delete();
        session()->flash('tabs_home', [
            'type' => 'address',
            'title' => 'Delete Address',
            'text' => 'Addresses Successfully Removed',
        ]);
    }
}
