<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DarajaApiController extends Controller
{
    // live==========

    public function generateAccessToken($consumer_key, $consumer_secret) //Active
    {
        // *** Authorization Request in PHP ***|
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $ch = curl_init($mpesaUrl);
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_HTTPHEADER => array('Content-Type:application/json; charset=utf8'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => $consumer_key . ':' . $consumer_secret
            )
        );
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return $response->access_token;
    }
    public function sendRequest($mpesa_url, $curl_post_data, $consumer_key, $consumer_secret)
    {
        $ch = curl_init($mpesa_url);
        curl_setopt($ch, CURLOPT_URL, $mpesa_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->generateAccessToken($consumer_key, $consumer_secret), 'Content-Type: application/json']);
        $data_string = json_encode($curl_post_data, JSON_UNESCAPED_SLASHES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Log::info($data_string);
        $curl_response = curl_exec($ch);
        curl_close($ch);
        Log::info($curl_response);
        return $curl_response;
    }
    public function registerUrl($data) //active
    {
        $body = array(
            'ShortCode' => $data['shortcode'],
            'ResponseType' => 'Completed',
            'ConfirmationURL' => url('') . '/api/c2b/confirmation',
            'ValidationURL' => url('') . '/api/c2b/validation'
        );
        Log::info($body);
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl' : 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';
        $response = json_decode($this->sendRequest($mpesaUrl, $body, $data['key'], $data['secret']));
        return $response;
    }
}
