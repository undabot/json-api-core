<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Attribute;

interface AttributeCollectionInterface extends \IteratorAggregate
{
    public function getAttributes(): array;

    public function getAttributeByName(string $name): ?AttributeInterface;
}
