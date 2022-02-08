<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

final class ResourceCollection implements ResourceCollectionInterface
{
    /** @param array<int,ResourceInterface> $resources */
    public function __construct(private array $resources)
    {
        $this->makeSureResourcesAreValid($resources);
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->getResources());
    }

    private function makeSureResourcesAreValid(array $resources): void
    {
        foreach ($resources as $resource) {
            if (false === ($resource instanceof ResourceInterface)) {
                $message = sprintf('ResourceInterface expected, %s given', \get_class($resource));

                throw new InvalidArgumentException($message);
            }
        }
    }
}
