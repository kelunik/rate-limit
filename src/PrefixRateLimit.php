<?php declare(strict_types=1);

namespace Kelunik\RateLimit;

/**
 * Prefixes keys with a certain string.
 */
class PrefixRateLimit implements RateLimit
{
    private RateLimit $rateLimit;
    private string $prefix;

    /**
     * Constructs a new instance.
     *
     * @param RateLimit $rateLimit Another rate limit instance.
     * @param string $prefix Prefix for rate limit keys.
     */
    public function __construct(RateLimit $rateLimit, string $prefix)
    {
        $this->rateLimit = $rateLimit;
        $this->prefix = $prefix;
    }

    /** @inheritdoc */
    public function get(string $id): int
    {
        return $this->rateLimit->get($this->prefix . $id);
    }

    /** @inheritdoc */
    public function increment(string $id): int
    {
        return $this->rateLimit->increment($this->prefix . $id);
    }

    /** @inheritdoc */
    public function getTtl(string $id): int
    {
        return $this->rateLimit->getTtl($this->prefix . $id);
    }
}
