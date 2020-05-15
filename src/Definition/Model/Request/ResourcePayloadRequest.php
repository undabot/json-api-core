<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request;

use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

interface ResourcePayloadRequest
{
    public function getResource(): ResourceInterface;
}
