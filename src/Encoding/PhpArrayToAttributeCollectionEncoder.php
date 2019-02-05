<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Attribute\Attribute;
use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollection;
use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;

class PhpArrayToAttributeCollectionEncoder implements PhpArrayToAttributeCollectionEncoderInterface
{
    public function decode(array $attributes): AttributeCollectionInterface
    {
        $decodedAttributes = [];
        foreach ($attributes as $attributeName => $attributeValue) {
            $decodedAttributes[] = new Attribute($attributeName, $attributeValue);
        }

        return new AttributeCollection($decodedAttributes);
    }
}
