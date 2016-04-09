<?php

namespace Kelunik\RateLimit;

use Amp\Promise;

/**
 * Prefixes keys with a certain string.
 *
 * @package Kelunik\RateLimit
 */
class PrefixRateLimit implements RateLimit {
    private $rateLimit;
    private $prefix;

    /**
     * Constructs a new instance.
     *
     * @param RateLimit $rateLimit another rate limit instance
     * @param string    $prefix prefix for rate limit keys
     */
    public function __construct(RateLimit $rateLimit, string $prefix) {
        $this->rateLimit = $rateLimit;
        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function get(string $id): Promise {
        return $this->rateLimit->get($this->prefix . $id);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function increment(string $id): Promise {
        return $this->rateLimit->increment($this->prefix . $id);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function ttl(string $id): Promise {
        return $this->rateLimit->ttl($this->prefix . $id);
    }
}