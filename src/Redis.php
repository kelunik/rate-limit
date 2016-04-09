<?php

namespace Kelunik\RateLimit;

use Amp\Promise;
use Amp\Redis\Client;
use function Amp\pipe;
use function Amp\resolve;

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

    /**
     * {@inheritdoc}
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function get(string $id): Promise {
        $fn = function () use ($id) {
            $count = yield $this->redis->get($id);

            return (int) $count;
        };

        return resolve($fn());
    }

    /**
     * {@inheritdoc}
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function increment(string $id): Promise {
        $fn = function () use ($id) {
            $count = yield $this->redis->incr($id);

            if ($count === 1) {
                yield $this->redis->expire($id, $this->ttl);
            }

            return $count;
        };

        return resolve($fn());
    }

    /**
     * {@inheritdoc}
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function ttl(string $id): Promise {
        $fn = function () use ($id) {
            $ttl = yield $this->redis->ttl($id);

            if ($ttl < 0) {
                return $this->ttl;
            } else {
                return $ttl;
            }
        };

        return resolve($fn());
    }
}
