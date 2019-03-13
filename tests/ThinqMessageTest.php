<?php

namespace R64\LaravelThinq\Tests;

use PHPUnit\Framework\TestCase;
use R64\LaravelThinq\ThinqMessage;

class ThinqMessageTest extends TestCase
{
    public $thinqMessage;

    public function setUp()
    {
        parent::setUp();
        $this->thinqMessage = new ThinqMessage('Hello, this is thinq message', '+2334988499', '+1234567890');
    }

    /**
     * @test
     */
    public function can_get_thinq_message()
    {
        $expected = $this->thinqMessage->getMessage();

        $this->assertEquals('Hello, this is thinq message', $expected['message']);
        $this->assertEquals('+2334988499', $expected['from_did']);
        $this->assertEquals('+1234567890', $expected['to_did']);
    }
}