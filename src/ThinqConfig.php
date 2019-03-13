<?php

namespace R64\LaravelThinq;

class ThinqConfig
{
    public function getApiKey()
    {
        return config('thinq.api_key');
    }

    public function getAccountId()
    {
        return config('thinq.account_id');
    }

    public function shouldDisableApiCalls()
    {
        return config('thinq.disable_api_calls');
    }
}