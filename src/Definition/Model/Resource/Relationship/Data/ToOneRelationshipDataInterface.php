<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Relationship\Data;

use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

interface ToOneRelationshipDataInterface extends RelationshipDataInterface
{
    public function getData(): ?ResourceIdentifierInterface;
}
