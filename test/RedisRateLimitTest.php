<?php declare(strict_types=1);

namespace Kelunik\RateLimit;

use PHPUnit\Framework\TestCase;
use function Amp\delay;
use function Amp\Redis\createRedisClient;

class RedisRateLimitTest extends TestCase
{
    private RateLimit $rateLimit;

    public function setUp(): void
    {
        $client = createRedisClient('redis://');
        $this->rateLimit = new RedisRateLimit($client, 3);
    }

    /** @test */
    public function isZeroOnStart()
    {
        $this->assertSame(0, $this->rateLimit->get("isZeroOnStart"));
    }

    /** @test */
    public function isOneAfterFirstIncrement()
    {
        $this->assertSame(1, $this->rateLimit->increment("isOneAfterFirstIncrement"));
    }

    /** @test */
    public function isResetAfterTtl()
    {
        $this->assertSame(1, $this->rateLimit->increment("isResetAfterTtl"));
        delay(4);
        $this->assertSame(0, $this->rateLimit->get("isResetAfterTtl"));
    }
}
