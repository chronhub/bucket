<?php

declare(strict_types=1);

namespace Bucket\Tests\Unit;

use Chronhub\Bucket\AbstractTokenBucket;

function newTokenBucket(int|float $capacity, int|float $rate): AbstractTokenBucket
{
    return new class($capacity, $rate) extends AbstractTokenBucket
    {
        public function consume(float $tokens = 1): bool
        {
            return $this->doConsume($tokens);
        }
    };
}

it('test abstract instance', function (int|float $capacity, int|float $rate) {
    $bucket = newTokenBucket($capacity, $rate);

    expect($bucket->capacity)->toBe($capacity)
        ->and($bucket->rate)->toBe($rate)
        ->and($bucket->remainingTokens())->toBe((float) $capacity);
})->with([
    'capacity' => [1, 2, 3, 0.5],
    'rate' => [1, 2, 3, 0.5],
]);

it('test consume token', function (int|float $capacity, int|float $rate) {
    $bucket = newTokenBucket($capacity, $rate);

    expect($bucket->consume())->toBeTrue()
        ->and($bucket->remainingTokens())->toBe((float) $capacity - 1);
})->with([
    'capacity' => [1, 2, 3, 0.5],
    'rate' => [1, 2, 3, 0.5],
]);

it('test consume token till capacity', function (int|float $capacity, int|float $rate) {
    $bucket = newTokenBucket($capacity, $rate);

    expect($bucket->consume($capacity))->toBeTrue()
        ->and($bucket->remainingTokens())->toBe(0.0);
})->with([
    'capacity' => [1, 2, 3, 0.5],
    'rate' => [1, 2, 3, 0.5],
]);

it('can not overflow capacity', function (int|float $capacity, int|float $rate) {
    $bucket = newTokenBucket($capacity, $rate);

    expect($bucket->consume($capacity + 1))->toBeFalse()
        ->and($bucket->remainingTokens())->toBe((float) $capacity);
})->with([
    'capacity' => [1, 2, 3, 0.5],
    'rate' => [1, 2, 3, 0.5],
]);
