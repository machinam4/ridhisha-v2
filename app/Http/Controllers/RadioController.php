<?php

namespace App\Http\Controllers;

use App\Models\Radio;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    // radio station routes
    public function radios()
    {
        // $radios = Radio::all();
        return view('radios', ['radios' => Radio::all()]);
    }
    public function add_radio(Request $request)
    {
        Radio::create([
            'name' => $request->name,
            'account' => $request->account,
        ]);
        return redirect()->route('radios');
    }
    public function update_radio(Request $request, Radio $radio)
    {
        $radio->update($request->all());
        return redirect()->route('radios');
    }
    public function delete_radio(Radio $radio)
    {
        $radio->delete();
        return redirect()->route('radios');
    }
}
