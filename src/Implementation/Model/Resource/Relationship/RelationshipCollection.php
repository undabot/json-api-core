<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Relationship;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollection implements RelationshipCollectionInterface
{
    /** @var array */
    private $relationships = [];

    public function __construct(array $relationships)
    {
        $this->makeSureThatItemsAreRelationships($relationships);
        $this->relationships = $relationships;
    }

    public function getRelationships(): array
    {
        return $this->relationships;
    }

    public function getIterator()
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
