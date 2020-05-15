<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

interface ResourceIdentifierToPhpArrayEncoderInterface
{
    public function encode(ResourceIdentifierInterface $resourceIdentifier);
}
