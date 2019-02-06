<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Model\Resource\Attribute\AttributeInterface;

class AttributeCollectionToPhpArrayEncoder implements AttributeCollectionToPhpArrayEncoderInterface
{
    public function encode(AttributeCollectionInterface $attributeCollection): array
    {
        $serializedAttributes = [];

        /** @var AttributeInterface $attribute */
        foreach ($attributeCollection as $attribute) {
            $serializedAttributes[$attribute->getName()] = $attribute->getValue();
        }

        return $serializedAttributes;
    }
}
