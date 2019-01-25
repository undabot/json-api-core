<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;

interface AttributeCollectionPhpArrayEncoderInterface
{
    public function encode(AttributeCollectionInterface $attributeCollection);
}
