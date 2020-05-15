<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToAttributeCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\Attribute;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\AttributeCollection;

class PhpArrayToAttributeCollectionEncoder implements PhpArrayToAttributeCollectionEncoderInterface
{
    public function encode(array $attributes): AttributeCollectionInterface
    {
        $decodedAttributes = [];
        foreach ($attributes as $attributeName => $attributeValue) {
            $decodedAttributes[] = new Attribute($attributeName, $attributeValue);
        }

        return new AttributeCollection($decodedAttributes);
    }
}
