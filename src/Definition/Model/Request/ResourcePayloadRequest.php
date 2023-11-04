<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request;

use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

/** @psalm-api */
interface ResourcePayloadRequest
{
    /** @psalm-suppress PossiblyUnusedMethod */
    public function getResource(): ResourceInterface;
}
