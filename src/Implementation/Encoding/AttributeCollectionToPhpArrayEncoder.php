<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\AttributeCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\Attributes;

class AttributeCollectionToPhpArrayEncoder implements AttributeCollectionToPhpArrayEncoderInterface
{
    public function encode(AttributeCollectionInterface $attributeCollection): Attributes
    {
        $serializedAttributes = [];

        /** @var AttributeInterface $attribute */
        foreach ($attributeCollection as $attribute) {
            $serializedAttributes[$attribute->getName()] = $attribute->getValue();
        }

        return new Attributes($serializedAttributes);
    }
}
