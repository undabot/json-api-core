<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

final class ResourceCollection implements ResourceCollectionInterface
{
    /** @var ResourceInterface[] */
    private $resources;

    public function __construct(array $resources)
    {
        $this->makeSureResourcesAreValid($resources);
        $this->resources = $resources;
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function getIterator()
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
