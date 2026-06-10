<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

class Resource implements ResourceInterface
{
    public function __construct(private readonly string $id, private readonly string $type, private readonly ?AttributeCollectionInterface $attributes = null, private readonly ?RelationshipCollectionInterface $relationships = null, private readonly ?LinkInterface $selfLink = null, private readonly ?MetaInterface $meta = null) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAttributes(): ?AttributeCollectionInterface
    {
        return $this->attributes;
    }

    public function getRelationships(): ?RelationshipCollectionInterface
    {
        return $this->relationships;
    }

    public function getSelfUrl(): ?LinkInterface
    {
        return $this->selfLink;
    }

    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }
}
