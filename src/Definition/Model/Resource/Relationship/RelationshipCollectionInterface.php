<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Relationship;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,RelationshipInterface>
 */
interface RelationshipCollectionInterface extends IteratorAggregate
{
    /**
     * @return RelationshipInterface[]
     */
    public function getRelationships(): array;

    public function getRelationshipByName(string $name): ?RelationshipInterface;
}
