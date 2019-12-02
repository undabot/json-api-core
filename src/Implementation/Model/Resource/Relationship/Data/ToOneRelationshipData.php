<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data;

use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToOneRelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

class ToOneRelationshipData implements ToOneRelationshipDataInterface
{
    /** @var null|ResourceIdentifierInterface */
    private $resourceIdentifier;

    private function __construct(?ResourceIdentifierInterface $resourceIdentifier)
    {
        $this->resourceIdentifier = $resourceIdentifier;
    }

    public static function makeEmpty(): self
    {
        return new self(null);
    }

    public static function make(ResourceIdentifierInterface $resourceIdentifier): self
    {
        return new self($resourceIdentifier);
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
