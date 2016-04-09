<?php

namespace Kelunik\RateLimit;

use Amp\Pause;
use Amp\Redis\Client;
use function Amp\wait;

class RedisTest extends \PHPUnit_Framework_TestCase {
    /** @var RateLimit */
    private $rateLimit;

    public function setUp() {
        $client = new Client("tcp://localhost:6379");
        $this->rateLimit = new Redis($client, 3);
    }

    /** @test */
    public function isZeroOnStart() {
        $this->assertSame(0, wait($this->rateLimit->get("isZeroOnStart")));
    }

    /** @test */
    public function isOneAfterFirstIncrement() {
        $this->assertSame(1, wait($this->rateLimit->increment("isOneAfterFirstIncrement")));
    }

    /** @test */
    public function isResetAfterTtl() {
        $this->assertSame(1, wait($this->rateLimit->increment("isResetAfterTtl")));
        sleep(4);
        $this->assertSame(0, wait($this->rateLimit->get("isResetAfterTtl")));
    }
}