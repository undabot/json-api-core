<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

final class ResourceIdentifierCollection implements ResourceIdentifierCollectionInterface
{
    /** @param array<int,ResourceIdentifierInterface> $resourceIdentifiers */
    public function __construct(private array $resourceIdentifiers)
    {
        $this->makeSureResourcesIdentifiersAreValid($resourceIdentifiers);
    }

    public function getResourceIdentifiers(): array
    {
        return $this->resourceIdentifiers;
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->getResourceIdentifiers());
    }

    private function makeSureResourcesIdentifiersAreValid(array $resourceIdentifiers): void
    {
        foreach ($resourceIdentifiers as $resourceIdentifier) {
            if (false === ($resourceIdentifier instanceof ResourceIdentifierInterface)) {
                $message = sprintf('ResourceIdentifierInterface expected, %s given', \get_class($resourceIdentifier));

                throw new InvalidArgumentException($message);
            }
        }
    }
}
