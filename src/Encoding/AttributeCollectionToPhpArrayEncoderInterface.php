<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;

interface AttributeCollectionToPhpArrayEncoderInterface
{
    public function encode(AttributeCollectionInterface $attributeCollection);
}
