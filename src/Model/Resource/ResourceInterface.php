<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource;

use Undabot\JsonApi\Model\Link\LinkInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

interface ResourceInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getAttributes(): ?AttributeCollectionInterface;

    public function getRelationships(): ?RelationshipCollectionInterface;

    public function getSelfUrl(): ?LinkInterface;

    public function getMeta(): ?MetaInterface;
}
