<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

interface ResourceIdentifierToPhpArrayEncoderInterface
{
    public function encode(ResourceIdentifierInterface $resourceIdentifier);
}
