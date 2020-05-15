<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;

interface PhpArrayToAttributeCollectionEncoderInterface
{
    public function encode(array $attributes): AttributeCollectionInterface;
}
