<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship;

use ArrayIterator;
use InvalidArgumentException;

class RelationshipCollection implements RelationshipCollectionInterface
{
    /** @var array */
    private $relationships = [];

    public function __construct(array $relationships)
    {
        $this->makeSureThatItemsAreRelationships($relationships);
        $this->relationships = $relationships;
    }

    private function makeSureThatItemsAreRelationships(array $relationships): void
    {
        foreach ($relationships as $relationship) {
            if (false === ($relationship instanceof Relationship)) {
                $message = sprintf('Item must be Relationship object, %s given', get_class($relationship));
                throw new InvalidArgumentException($message);
            }
        }
    }

    public function getRelationships(): array
    {
        return $this->relationships;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getRelationships());
    }
}
