<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Relationship;

use IteratorAggregate;

interface RelationshipCollectionInterface extends IteratorAggregate
{
    public function getRelationships(): array;

    public function getRelationshipByName(string $name): ?RelationshipInterface;
}
