<?php

namespace Kelunik\RateLimit;

use Amp\Promise;

/**
 * Provides methods for rate limiting.
 *
 * @package Kelunik\RateLimit
 */
interface RateLimit {
    /**
     * Gets the current value.
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function get(string $id): Promise;

    /**
     * Increments the current value and returns the current value afterwards.
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function increment(string $id): Promise;

    /**
     * Gets the number of seconds until the rate limit is reset.
     *
     * @param string $id rate limit key
     * @return Promise
     */
    public function ttl(string $id): Promise;
}