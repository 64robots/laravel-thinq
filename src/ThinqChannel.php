<?php

namespace R64\LaravelThinq;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;

class ThinqChannel
{
    protected $thinq;
    protected $events;

    public function __construct(Thinq $thinq, Dispatcher $events)
    {
        $this->thinq = $thinq;
        $this->events = $events;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toThinq($notifiable);

        if (!($message instanceof ThinqMessage)) {
            return;
        }

        if (property_exists($notification, 'silent') && $notification->silent) {
            $this->thinq->withMessage($message)->sentSilentSms();
        } else {
            $this->thinq->withMessage($message)->sentSms();
        }
    }
}
