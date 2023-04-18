<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Presenter_Sessions;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function confirmation(Request $request)
    {
        if ($request->TransactionType === 'Pay Bill') {
            $insession = Presenter_Sessions::where('status', 1)->where('account', 'LIKE', '%' . $request->BillRefNumber . '%')->first();
        } else {
            $insession = Presenter_Sessions::where('status', 1)->where('shortcode', $request->BusinessShortCode)->first();
        }

        // dd($insession);
        $presenter = 1;
        $session_id = 1;
        if ($insession != null) {
            $session_id = $insession->id;
            $presenter = $insession->presenter->id;
        }
        $data = json_decode($request->getContent());

        Players::create([
            'TransactionType' => $data->TransactionType,
            'TransID' => $data->TransID,
            'TransTime' => $data->TransTime,
            'TransAmount' => $data->TransAmount,
            'BusinessShortCode' => $data->BusinessShortCode,
            'BillRefNumber' => $data->BillRefNumber,
            'InvoiceNumber' => $data->InvoiceNumber,
            'OrgAccountBalance' => $data->OrgAccountBalance,
            'ThirdPartyTransID' => $data->ThirdPartyTransID,
            'MSISDN' => $data->MSISDN,
            'FirstName' => $data->FirstName,
            'user_id' => $presenter,
            'session_id' => $session_id,
        ]);

        // Players::create([
        //     'TransactionType' => $request->TransactionType,
        //     'TransID' => $request->TransID,
        //     'TransTime' => $request->TransTime,
        //     'TransAmount' => $request->TransAmount,
        //     'BusinessShortCode' => $request->BusinessShortCode,
        //     'BillRefNumber' => $request->BillRefNumber,
        //     'InvoiceNumber' => $request->InvoiceNumber,
        //     'OrgAccountBalance' => $request->OrgAccountBalance,
        //     'ThirdPartyTransID' => $request->ThirdPartyTransID,
        //     'MSISDN' => $request->MSISDN,
        //     'FirstName' => $request->FirstName,
        //     'user_id' => $presenter,
        // ]);

        return "success";
    }
    public function validation(Request $request)
    {
        return  [
            "ResultCode" => 0,
            "ResultDesc" => "Accept Service"
        ];
    }
}
