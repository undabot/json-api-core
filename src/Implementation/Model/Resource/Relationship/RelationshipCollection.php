<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Relationship;

use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollection implements RelationshipCollectionInterface
{
    /** @var RelationshipInterface[] */
    private array $relationships = [];

    /** @param RelationshipInterface[] $relationships */
    public function __construct(array $relationships)
    {
        $this->makeSureThatItemsAreRelationships($relationships);
        $this->relationships = $relationships;
    }

    /**
     * @return RelationshipInterface[]
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    /**
     * @return \ArrayIterator<int,RelationshipInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->getRelationships());
    }

    public function getRelationshipByName(string $name): ?RelationshipInterface
    {
        foreach ($this->getRelationships() as $relationship) {
            if ($name === $relationship->getName()) {
                return $relationship;
            }
        }

        return null;
    }

    /** @param RelationshipInterface[] $relationships */
    private function makeSureThatItemsAreRelationships(array $relationships): void
    {
        foreach ($relationships as $relationship) {
            if (false === ($relationship instanceof Relationship)) {
                $message = sprintf('Item must be Relationship object, %s given', \get_class($relationship));

                throw new \InvalidArgumentException($message);
            }
        }
    }
}
