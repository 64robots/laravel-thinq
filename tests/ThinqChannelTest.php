<?php

namespace R64\LaravelThinq\Tests;

use Mockery;
use R64\LaravelThinq\Thinq;
use R64\LaravelThinq\ThinqChannel;
use R64\LaravelThinq\ThinqMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ThinqChannelTest extends MockeryTestCase
{
    public $thinq;
    public $channel;

    public $dispatcher;

    public function setUp()
    {
        parent::setUp();

        $this->thinq = Mockery::mock(Thinq::class);
        $this->dispatcher = Mockery::mock(Dispatcher::class);

        $this->channel = new ThinqChannel($this->thinq, $this->dispatcher);
    }

    /**
     * @test
     */
    public function can_send_thinq_message()
    {
        $notifiable = new Class {};
        $notification = Mockery::mock(Notification::class);
        
        $message = new ThinqMessage('Message', '+1234567890', '+2346788778');
        $notification->shouldReceive('toThinq')->andReturn($message);
        
        $this->thinq->shouldReceive('withMessage')
            ->with($message)
            ->andReturn($this->thinq);

        $this->thinq->shouldReceive('sentSms')
            ->once();

        App::shouldReceive('environment')
            ->andReturn('production');

        $this->channel->send($notifiable, $notification);
    }
}