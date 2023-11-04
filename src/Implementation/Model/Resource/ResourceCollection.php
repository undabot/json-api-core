<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

/** @psalm-suppress UnusedClass */
final class ResourceCollection implements ResourceCollectionInterface
{
    /**
     * @var array<ResourceInterface>
     */
    private array $resources;

    /** @param ResourceInterface[] $resources */
    /** @psalm-suppress PossiblyUnusedMethod */
    /** @phpstan-ignore-next-line */
    public function __construct(array $resources)
    {
        try {
            Assertion::allIsInstanceOf($resources, ResourceInterface::class);
        } catch (AssertionFailedException $exception) {
            //            $message = sprintf('ResourceIdentifierInterface expected, %s given', \get_class($resourceIdentifier));
            //
            //            throw new InvalidArgumentException($message);
        }
        $this->resources = $resources;
    }

    /**
     * @return ResourceInterface[] $resources
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @return \ArrayIterator<int,ResourceInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->getResources());
    }
}
