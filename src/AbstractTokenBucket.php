<?php

declare(strict_types=1);

namespace Chronhub\Bucket;

use InvalidArgumentException;

use function microtime;
use function min;

abstract class AbstractTokenBucket
{
    protected float $tokens;

    protected float $lastRefillTime;

    public function __construct(
        public readonly int|float $capacity,
        public readonly int|float $rate
    ) {
        if ($capacity <= 0 || $rate <= 0) {
            throw new InvalidArgumentException('Capacity and rate must be greater than zero.');
        }

        $this->tokens = $capacity;
        $this->lastRefillTime = microtime(true);
    }

    public function remainingTokens(): int|float
    {
        return $this->tokens;
    }

    abstract public function consume(float $tokens = 1): bool;

    protected function doConsume(float $tokens): bool
    {
        $this->refillTokens();

        if ($this->tokens >= $tokens) {
            $this->tokens -= $tokens;

            return true;
        }

        return false;
    }

    /**
     * Refill the token bucket.
     */
    protected function refillTokens(): void
    {
        $now = microtime(true);
        $timePassed = $now - $this->lastRefillTime;
        $this->tokens = min($this->capacity, $this->tokens + $timePassed * $this->rate);
        $this->lastRefillTime = $now;
    }
}
