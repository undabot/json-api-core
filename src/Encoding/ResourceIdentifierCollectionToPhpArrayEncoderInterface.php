<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;

interface ResourceIdentifierCollectionToPhpArrayEncoderInterface
{
    public function encode(ResourceIdentifierCollectionInterface $resourceIdentifierCollection);
}
