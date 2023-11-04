<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

final class ResourceIdentifierCollection implements ResourceIdentifierCollectionInterface
{
    /** @var ResourceIdentifierInterface[] */
    private $resourceIdentifiers;

    /** @param ResourceIdentifierInterface[] $resourceIdentifiers */
    public function __construct(array $resourceIdentifiers)
    {
        try {
            Assertion::allIsInstanceOf($resourceIdentifiers, ResourceIdentifierInterface::class);
        } catch (AssertionFailedException $exception) {
            //            $message = sprintf('ResourceIdentifierInterface expected, %s given', \get_class($resourceIdentifier));
            //
            //            throw new InvalidArgumentException($message);
        }
        $this->resourceIdentifiers = $resourceIdentifiers;
    }

    /**
     * @return ResourceIdentifierInterface[]
     */
    public function getResourceIdentifiers(): array
    {
        return $this->resourceIdentifiers;
    }

    /**
     * @return \ArrayIterator<int,ResourceIdentifierInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->getResourceIdentifiers());
    }
}
