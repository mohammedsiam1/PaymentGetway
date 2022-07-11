<?php

namespace App\Services\Payments;

use Exception;
use Illuminate\Support\Facades\Http;

class Thawani
{

    const TEST_URL = 'https://uatcheckout.thawani.om/api/v1';
    const LIVE_URL = 'https://checkout.thawani.om/api/v1';

    protected $secretkey;
    protected $publishkey;
    protected $baseUrl;
    protected $mode;


    public function __construct($secretkey, $publishkey, $mode = 'test')
    {

        $this->secretkey = $secretkey;
        $this->publishkey = $publishkey;
        $this->mode = $mode;
        if ($mode == 'test') {
            $this->baseUrl = self::TEST_URL;
        } else {
            $this->baseUrl = self::LIVE_URL;
        }
    }


    public function createCheckoutSession($data)
    {

        $response =  Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'thawani-api-key' => $this->secretkey,
            ])->asJson()
            ->post('/checkout/session', $data);


        $body = $response->json();

        if ($body['success'] == true && $body['code'] == 2004) {

            return $body['data']['session_id'];
        }

        throw new Exception($body['description'], $body['code']);
    }


    public function getcheckoutsession($session_id)
    {

        $response =  Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'thawani-api-key' => $this->secretkey,
            ])->asJson()
            ->get('/checkout/session', $session_id);

        if ($response['success'] == true && $response['code'] == 2000)
            return $response;

        throw new Exception($response['description'], $response['code']);
    }


    public function getpayurl($session_id)
    {
        if ($this->mode == 'test') {
            return  "https://uatcheckout.thawani.om/pay/{$session_id}?key={$this->publishkey}";
        }
        return  "https://checkout.thawani.om/pay/{$session_id}?key={$this->publishkey}";
    }
}
