<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Relationship;

use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;

interface RelationshipInterface
{
    public function getName(): string;

    public function getLinks(): ?LinkCollectionInterface;

    public function getData(): ?RelationshipDataInterface;

    public function getMeta(): ?MetaInterface;
}
