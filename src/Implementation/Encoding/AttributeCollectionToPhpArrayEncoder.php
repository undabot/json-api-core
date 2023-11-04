<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\AttributeCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;

/** @psalm-suppress UnusedClass */
class AttributeCollectionToPhpArrayEncoder implements AttributeCollectionToPhpArrayEncoderInterface
{
    public function encode(AttributeCollectionInterface $attributeCollection): array
    {
        $serializedAttributes = [];

        foreach ($attributeCollection as $attribute) {
            $serializedAttributes[$attribute->getName()] = $attribute->getValue();
        }

        return $serializedAttributes;
    }
}
