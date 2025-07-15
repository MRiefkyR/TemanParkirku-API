<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransChargeController extends Controller
{
    public function index(Request $request)
    {
        $server_key = env('MIDTRANS_SERVER_KEY'); // Taruh di .env
        $is_production = false;

        $api_url = $is_production ?
            'https://app.midtrans.com/snap/v1/transactions' :
            'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Request body dari Android langsung diteruskan ke Midtrans
        $request_body = $request->getContent();

        $response = $this->chargeAPI($api_url, $server_key, $request_body);

        return response($response['body'], $response['http_code'])
                ->header('Content-Type', 'application/json');
    }

    private function chargeAPI($api_url, $server_key, $request_body)
    {
        $ch = curl_init();
        $curl_options = [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($server_key . ':'),
            ],
            CURLOPT_POSTFIELDS => $request_body,
        ];
        curl_setopt_array($ch, $curl_options);

        $result = [
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        ];
        return $result;
    }
}
