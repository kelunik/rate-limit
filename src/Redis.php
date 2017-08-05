<?php

namespace Kelunik\RateLimit;

use Amp\Promise;
use Amp\Redis\Client;
use function Amp\call;

/**
 * Redis driver.
 *
 * @package Kelunik\RateLimit
 */
class Redis implements RateLimit {
    private $redis;
    private $ttl;

    /**
     * Constructs a new instance.
     *
     * @param Client $redis
     * @param int    $ttl
     */
    public function __construct(Client $redis, int $ttl) {
        $this->redis = $redis;
        $this->ttl = $ttl;
    }

    /** @inheritdoc */
    public function get(string $id): Promise {
        return call(function () use ($id) {
            $count = yield $this->redis->get($id);

            return (int) $count;
        });
    }

    /** @inheritdoc */
    public function increment(string $id): Promise {
        return call(function () use ($id) {
            $count = yield $this->redis->incr($id);

            if ($count === 1) {
                yield $this->redis->expire($id, $this->ttl);
            }

            return $count;
        });
    }

    /** @inheritdoc */
    public function ttl(string $id): Promise {
        return call(function () use ($id) {
            $ttl = yield $this->redis->ttl($id);

            if ($ttl < 0) {
                return $this->ttl;
            } else {
                return $ttl;
            }
        });
    }
}
