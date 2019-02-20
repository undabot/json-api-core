<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship\Data;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollection;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;

class ToManyRelationshipData implements ToManyRelationshipDataInterface
{
    /** @var ResourceIdentifierCollectionInterface */
    private $resourceIdentifierCollection;

    public static function makeEmpty(): self
    {
        return new self(new ResourceIdentifierCollection([]));
    }

    public static function make(ResourceIdentifierCollectionInterface $resourceIdentifierCollection): self
    {
        return new self($resourceIdentifierCollection);
    }

    public function __construct(ResourceIdentifierCollectionInterface $resourceIdentifierCollection)
    {
        $this->resourceIdentifierCollection = $resourceIdentifierCollection;
    }

    public function isEmpty(): bool
    {
        return null === $this->resourceIdentifierCollection ||
            0 === count($this->resourceIdentifierCollection->getResourceIdentifiers());
    }

    public function getData(): ResourceIdentifierCollectionInterface
    {
        return $this->resourceIdentifierCollection;
    }
}
