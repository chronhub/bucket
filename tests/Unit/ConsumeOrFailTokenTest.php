<?php

declare(strict_types=1);

namespace Chronhub\Bucket\Tests\Unit;

use Chronhub\Bucket\ConsumeOrFailToken;
use Chronhub\Bucket\NoMoreTokenBucketAvailable;

it('raise exception when no more token available', function (): void {
    $bucket = new ConsumeOrFailToken(1, 1);

    $this->assertTrue($bucket->consume());

    $bucket->consume();
})->throws(NoMoreTokenBucketAvailable::class, 'No more token bucket available');
