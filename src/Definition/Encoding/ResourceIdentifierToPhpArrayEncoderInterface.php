<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

interface ResourceIdentifierToPhpArrayEncoderInterface
{
    /** @return array<string,mixed> */
    public function encode(ResourceIdentifierInterface $resourceIdentifier);
}
