<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship;

use IteratorAggregate;

interface RelationshipCollectionInterface extends IteratorAggregate
{
    public function getRelationships(): array;
}
