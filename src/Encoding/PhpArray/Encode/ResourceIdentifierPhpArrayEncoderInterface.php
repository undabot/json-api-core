<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

interface ResourceIdentifierPhpArrayEncoderInterface
{
    public function encode(ResourceIdentifierInterface $resourceIdentifier);
}
