<?php

namespace App\Payment;

use Exception;

class Payze extends Payment
{
    private Object $paymentConfig;


    private function sendRequest(String $endpoint, String $data, Array $headers, String $method) : Object {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->paymentConfig->api_endpoint . $endpoint,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $result = json_decode($response);

        return (object)[
            'result' => $result,
            'httpcode' => $httpcode
        ];
    }

    protected function validateConfig(object $config) : void
    {   
        // dd($config->apiKey);
        if(!isset($config->apiKey) || empty($config->apiKey)) {
            throw new Exception('Payze PAYMENT CONFIG ERROR: No API Key provided.');
        }

        if(!isset($config->apiSecret) || empty($config->apiSecret)) {
            throw new Exception('Payze PAYMENT CONFIG ERROR: No API Secret provided.');
        }
    }

    protected function prepare(): void
    {
        $this->paymentConfig = (object)config('paymentconfigs.payze');
    }

    public function saveCard(object $config) : object {
        dd($this->paymentConfig);
        $callback_success = $config->success;
        $callback_fail = $config->fail;

        $headers = [
            "accept: application/json",
            "content-type: application/json"
        ];

        $data = json_encode([
            "method"=> "addCard",
            "apiKey"=> $this->config->apiKey,
            "apiSecret"=> $this->config->apiSecret,
            "data"=> [
                "callback"=> $callback_success,
                "callbackError"=> $callback_fail,
                "hookUrl"=> '',
                "amount"=> 0,
                "currency"=> "GEL",
                "hookRefund"=> false
            ]
        ]);

        $response =  $this->sendRequest('api/v1', $data, $headers, 'POST');
        
        return $response;
    }
}