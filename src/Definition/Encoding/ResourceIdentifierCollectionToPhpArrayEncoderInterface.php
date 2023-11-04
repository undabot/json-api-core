<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;

interface ResourceIdentifierCollectionToPhpArrayEncoderInterface
{
    /** @return array<int,array<string,mixed>> */
    public function encode(ResourceIdentifierCollectionInterface $resourceIdentifierCollection): array;
}
