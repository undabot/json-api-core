<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;

interface ResourceIdentifierCollectionPhpArrayEncoderInterface
{
    public function encode(ResourceIdentifierCollectionInterface $resourceIdentifierCollection);
}
