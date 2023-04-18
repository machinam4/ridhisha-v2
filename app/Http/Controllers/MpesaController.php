<?php

namespace App\Http\Controllers;

use App\Models\Mpesa;
use App\Models\Radio;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    // mpesa station routes
    public function mpesas()
    {
        // $mpesas = Mpesa::all();
        return view('mpesas', ['mpesas' => Mpesa::all()]);
    }
    public function add_mpesa(Request $request)
    {
        try {
            $ApiController = new DarajaApiController;
            $registration = $ApiController->generateAccessToken($request->key, $request->secret);
            Mpesa::create($request->all());
        } catch (\Throwable $th) {
            return back()->withErrors(['secret' => 'Kindly Confirm ShortCode Details']);
        }
        return back()->with('message', 'Shortcode Added!');
    }
    public function update_mpesa(Request $request, Mpesa $mpesa)
    {
        $mpesa->update($request->all());
        return back()->with('message', 'Shortcode Updated!');
    }
    public function delete_mpesa(Mpesa $mpesa)
    {
        $mpesa->delete();
        return back()->with('message', 'Shortcode Deleted!');
    }

    public function registerurl(Mpesa $mpesa)
    {
        $data = [
            'shortcode' => $mpesa->shortcode,
            'key' => $mpesa->key,
            'secret' => $mpesa->secret,
        ];
        $ApiController = new DarajaApiController;
        $registration = $ApiController->registerURL($data);

        return back()->with('message', $registration->errorMessage);
    }
}
