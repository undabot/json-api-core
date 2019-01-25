<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship\Data;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

class ToOneRelationshipData implements ToOneRelationshipDataInterface
{
    /** @var ResourceIdentifierInterface|null */
    private $resourceIdentifier;

    public static function makeEmpty(): self
    {
        return new self(null);
    }

    public static function make(ResourceIdentifierInterface $resourceIdentifier): self
    {
        return new self($resourceIdentifier);
    }

    private function __construct(?ResourceIdentifierInterface $resourceIdentifier)
    {
        $this->resourceIdentifier = $resourceIdentifier;
    }

    public function isEmpty(): bool
    {
        return null === $this->resourceIdentifier;
    }

    public function getData(): ?ResourceIdentifierInterface
    {
        return $this->resourceIdentifier;
    }
}
