<?php

namespace R64\LaravelThinq;

use Exception;

class Thinq
{
    protected $thinqMessage;
    protected $account_id;
    protected $api_key;

    public function __construct()
    {
        $this->account_id = config('thinq.account_id');
        $this->api_key = config('thinq.api_key');
    }

    public function withMessage(ThinqMessage $message)
    {
        $this->thinqMessage = $message;

        return $this;
    }


    public function sentSms()
    {
        $data = $this->thinqMessage->getMessage();
        $authorization = base64_encode($this->api_key);
        $url = "https://api.thinq.com/account/{$this->account_id}/product/origination/sms/send";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Basic {$authorization}",
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)))
        );

        $result = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode >= 400) {
            throw new Exception($result);
        }
    }

    public function sentSilentSms()
    {
        try {
            $this->sentSms();
        } catch(Exception $exception) {

        }
    }
}