<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Relationship\Data;

interface RelationshipDataInterface
{
    public function isEmpty(): bool;

    public function getData();
}
