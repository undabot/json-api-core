<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Relationship;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollection implements RelationshipCollectionInterface
{
    /** @param array<int,RelationshipInterface> $relationships */
    public function __construct(private array $relationships)
    {
        $this->makeSureThatItemsAreRelationships($relationships);
    }

    public function getRelationships(): array
    {
        return $this->relationships;
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->getRelationships());
    }

    public function getRelationshipByName(string $name): ?RelationshipInterface
    {
        /** @var RelationshipInterface $relationship */
        foreach ($this->getRelationships() as $relationship) {
            if ($name === $relationship->getName()) {
                return $relationship;
            }
        }

        return null;
    }

    private function makeSureThatItemsAreRelationships(array $relationships): void
    {
        foreach ($relationships as $relationship) {
            if (false === ($relationship instanceof Relationship)) {
                $message = sprintf('Item must be Relationship object, %s given', \get_class($relationship));

                throw new InvalidArgumentException($message);
            }
        }
    }
}
