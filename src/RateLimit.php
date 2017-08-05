<?php

namespace Kelunik\RateLimit;

use Amp\Promise;

/**
 * Provides rate limiting.
 */
interface RateLimit {
    /**
     * Gets the current value.
     *
     * @param string $id Rate limit key.
     *
     * @return Promise
     */
    public function get(string $id): Promise;

    /**
     * Increments the current value and returns the new value afterwards.
     *
     * @param string $id Rate limit key.
     *
     * @return Promise
     */
    public function increment(string $id): Promise;

    /**
     * Gets the number of seconds until the rate limit is reset.
     *
     * @param string $id Rate limit key.
     *
     * @return Promise
     */
    public function ttl(string $id): Promise;
}
