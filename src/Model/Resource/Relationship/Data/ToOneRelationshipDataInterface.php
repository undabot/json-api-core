<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship\Data;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

interface ToOneRelationshipDataInterface extends RelationshipDataInterface
{
    public function getData(): ?ResourceIdentifierInterface;
}
