<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource;

use ArrayIterator;
use InvalidArgumentException;

final class ResourceCollection implements ResourceCollectionInterface
{
    /** @var ResourceInterface[] */
    private $resources;

    public function __construct(array $resources)
    {
        $this->makeSureResourcesAreValid($resources);
        $this->resources = $resources;
    }

    private function makeSureResourcesAreValid(array $resources): void
    {
        foreach ($resources as $resource) {
            if (false === ($resource instanceof ResourceInterface)) {
                $message = sprintf('ResourceInterface expected, %s given', get_class($resource));
                throw new InvalidArgumentException($message);
            }
        }
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getResources());
    }
}
