<?php

namespace R64\LaravelThinq;

class ThinqMessage
{
    protected $message;
    protected $from;
    protected $to;

    public function __construct(string $message, string $from, string $to)
    {
        $this->message = $message;
        $this->from = $from;
        $this->to = $to;
    }

    public function getMessage()
    {
        return [
            "from_did" => $this->from,
            "to_did" => $this->to,
            "message" => $this->message
        ];
    }
}