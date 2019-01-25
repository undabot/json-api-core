<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource;

use ArrayIterator;
use InvalidArgumentException;

final class ResourceIdentifierCollection implements ResourceIdentifierCollectionInterface
{
    /** @var ResourceIdentifierInterface[] */
    private $resourceIdentifiers;

    public function __construct(array $resourceIdentifiers)
    {
        $this->makeSureResourcesIdentifiersAreValid($resourceIdentifiers);
        $this->resourceIdentifiers = $resourceIdentifiers;
    }

    private function makeSureResourcesIdentifiersAreValid(array $resourceIdentifiers): void
    {
        foreach ($resourceIdentifiers as $resourceIdentifier) {
            if (false === ($resourceIdentifier instanceof ResourceIdentifierInterface)) {
                $message = sprintf('ResourceIdentifierInterface expected, %s given', get_class($resourceIdentifier));
                throw new InvalidArgumentException($message);
            }
        }
    }

    public function getResourceIdentifiers(): array
    {
        return $this->resourceIdentifiers;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getResourceIdentifiers());
    }
}
