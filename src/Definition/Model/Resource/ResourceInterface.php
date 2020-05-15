<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource;

use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;

interface ResourceInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getAttributes(): ?AttributeCollectionInterface;

    public function getRelationships(): ?RelationshipCollectionInterface;

    public function getSelfUrl(): ?LinkInterface;

    public function getMeta(): ?MetaInterface;
}
