<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;

interface AttributeCollectionJsonDecoderInterface
{
    public function decode(array $attributes): AttributeCollectionInterface;
}
