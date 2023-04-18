<?php

namespace App\Http\Controllers;

use App\Models\Mpesa;
use App\Models\Radio;
use App\Models\Radio_Mpesa;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    // radio station routes
    public function radios()
    {
        // $radios = Radio::all();
        return view('radios', ['radios' => Radio::all(), 'mpesas' => Mpesa::all()]);
    }
    public function add_radio(Request $request)
    {
        Radio::create([
            'name' => $request->name,
            'account' => $request->account,
        ]);
        return redirect()->route('radios');
    }
    public function link_mpesas(Request $request, Radio $radio)
    {
        Radio_Mpesa::where('radio_id', $radio->id)->delete();
        foreach ($request->mpesas as $mpesa) {
            Radio_Mpesa::create([
                'radio_id' => $radio->id,
                'mpesa_id' => $mpesa,
                'account' => $radio->account,
            ]);
        }

        return back()->with('message', 'Shortcode Added!');
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
