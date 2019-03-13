<?php

namespace R64\LaravelThinq\Tests;

use Mockery;
use R64\LaravelThinq\Thinq;
use R64\LaravelThinq\ThinqConfig;
use R64\LaravelThinq\ThinqMessage;
use Illuminate\Support\Facades\App;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ThinqTest extends MockeryTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->config = Mockery::mock(ThinqConfig::class);
        $this->thinqMessage = Mockery::mock(ThinqMessage::class);

        $this->thinq = new Thinq($this->config);
    }

    /**
     * @test
     */
    public function can_send_a_message_to_thinq()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unauthorized');

        $this->config->shouldReceive([
            'getApiKey' => '12345xxxx',
            'getAccountId' => 'sdxxx12345',
        ]);

        $this->thinqMessage->shouldReceive('getMessage')
            ->andReturn([
                'from_did' => '+1234567890',
                'to_did' => '+2346788778',
                'message' => 'Message text',
            ]);

        $this->thinq->thinqMessage = $this->thinqMessage;

        App::shouldReceive('environment')
            ->andReturn('production');

        $this->thinq->sentSms();
    }

    /**
     * @test
     */
    public function can_send_silent_sms_message_to_thinq()
    {
        $this->config->shouldReceive([
            'getApiKey' => '12345xxxx',
            'getAccountId' => 'sdxxx12345',
        ]);

        $this->thinqMessage->shouldReceive('getMessage')
            ->andReturn([
                'from_did' => '+1234567890',
                'to_did' => '+2346788778',
                'message' => 'Message text',
            ]);

        $this->thinq->thinqMessage = $this->thinqMessage;

        App::shouldReceive('environment')
            ->andReturn('production');

        $this->thinq->sentSilentSms();
    }

    /**
     * @test
     * 
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function will_not_make_api_call_when_disabled()
    {
        $this->config->shouldReceive([
            'getApiKey' => '12345xxxx',
            'getAccountId' => 'sdxxx12345',
            'shouldDisableApiCalls' => true,
        ]);

        $this->config->shouldReceive('shouldDisableApiCalls')
            ->andReturn(true);

        $this->thinqMessage->shouldReceive('getMessage')
            ->andReturn([
                'from_did' => '+1234567890',
                'to_did' => '+2346788778',
                'message' => 'Message text',
            ]);

        $this->thinq->thinqMessage = $this->thinqMessage;

        App::shouldReceive('environment')
            ->andReturn('local');

        $expected = $this->thinq->sentSms();
        $this->assertNull($expected);
    }
}