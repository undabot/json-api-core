<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Attribute;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,AttributeInterface>
 */
interface AttributeCollectionInterface extends \IteratorAggregate
{
    /** @return AttributeInterface[] */
    public function getAttributes(): array;

    /** @psalm-suppress PossiblyUnusedMethod */
    public function getAttributeByName(string $name): ?AttributeInterface;
}
