<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;

interface PhpArrayToAttributeCollectionEncoderInterface
{
    public function decode(array $attributes): AttributeCollectionInterface;
}
