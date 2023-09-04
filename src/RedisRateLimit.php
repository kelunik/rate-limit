<?php declare(strict_types=1);

namespace Kelunik\RateLimit;

use Amp\Redis\RedisClient;

/**
 * Redis driver.
 *
 * @package Kelunik\RateLimit
 */
class RedisRateLimit implements RateLimit
{
    private RedisClient $redis;
    private int $ttl;

    /**
     * Constructs a new instance.
     */
    public function __construct(RedisClient $redis, int $ttl)
    {
        $this->redis = $redis;
        $this->ttl = $ttl;
    }

    /** @inheritdoc */
    public function get(string $id): int
    {
        $count = $this->redis->get($id);

        return (int) $count;
    }

    /** @inheritdoc */
    public function increment(string $id): int
    {
        $count = $this->redis->increment($id);

        if ($count === 1) {
            $this->redis->expireIn($id, $this->ttl);
        }

        return $count;
    }

    /** @inheritdoc */
    public function getTtl(string $id): int
    {
        $ttl = $this->redis->getTtl($id);

        if ($ttl < 0) {
            return $this->ttl;
        }

        return $ttl;
    }
}
