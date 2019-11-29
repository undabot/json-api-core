<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;

interface ResourceIdentifierCollectionToPhpArrayEncoderInterface
{
    public function encode(ResourceIdentifierCollectionInterface $resourceIdentifierCollection);
}
