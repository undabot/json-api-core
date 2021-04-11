<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;

interface ResourceCollectionToPhpArrayEncoderInterface
{
    /** @return array<int,array<string,mixed>> */
    public function encode(ResourceCollectionInterface $resource);
}
