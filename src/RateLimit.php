<?php declare(strict_types=1);

namespace Kelunik\RateLimit;

/**
 * Provides rate limiting.
 */
interface RateLimit
{
    /**
     * Gets the current value.
     *
     * @param string $id Rate limit key.
     */
    public function get(string $id): int;

    /**
     * Increments the current value and returns the new value.
     *
     * @param string $id Rate limit key.
     */
    public function increment(string $id): int;

    /**
     * Gets the number of seconds until the rate limit is reset.
     *
     * @param string $id Rate limit key.
     */
    public function getTtl(string $id): int;
}
