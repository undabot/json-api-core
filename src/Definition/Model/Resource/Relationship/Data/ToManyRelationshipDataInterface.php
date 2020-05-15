<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Relationship\Data;

use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;

interface ToManyRelationshipDataInterface extends RelationshipDataInterface
{
    public function getData(): ResourceIdentifierCollectionInterface;
}
