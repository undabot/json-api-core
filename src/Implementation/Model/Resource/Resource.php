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
    /** @var string */
    private $id;

    /** @var string */
    private $type;

    /** @var AttributeCollectionInterface|null */
    private $attributes;

    /** @var RelationshipCollectionInterface|null */
    private $relationships;

    /** @var LinkInterface|null */
    private $selfLink;

    /** @var MetaInterface|null */
    private $meta;

    public function __construct(
        string $id,
        string $type,
        ?AttributeCollectionInterface $attributes = null,
        ?RelationshipCollectionInterface $relationships = null,
        ?LinkInterface $selfLink = null,
        ?MetaInterface $meta = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->attributes = $attributes;
        $this->relationships = $relationships;
        $this->selfLink = $selfLink;
        $this->meta = $meta;
    }

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
