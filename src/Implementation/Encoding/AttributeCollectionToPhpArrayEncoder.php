<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use ArrayObject;
use Undabot\JsonApi\Definition\Encoding\AttributeCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeInterface;

class AttributeCollectionToPhpArrayEncoder implements AttributeCollectionToPhpArrayEncoderInterface
{
    public function encode(AttributeCollectionInterface $attributeCollection): ArrayObject
    {
        $serializedAttributes = [];

        /** @var AttributeInterface $attribute */
        foreach ($attributeCollection as $attribute) {
            $serializedAttributes[$attribute->getName()] = $attribute->getValue();
        }

        return new ArrayObject($serializedAttributes);
    }
}
