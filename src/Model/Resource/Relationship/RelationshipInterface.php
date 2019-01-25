<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\Relationship\Data\RelationshipDataInterface;

interface RelationshipInterface
{
    public function getName(): string;

    public function getLinks(): ?LinkCollectionInterface;

    public function getData(): ?RelationshipDataInterface;

    public function getMeta(): ?MetaInterface;
}
