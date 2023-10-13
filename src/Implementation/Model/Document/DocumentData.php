<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Document;

use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceCollection;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifierCollection;

class DocumentData implements DocumentDataInterface
{
    /** @var null|ResourceCollection|ResourceIdentifierCollection|ResourceIdentifierInterface|ResourceInterface */
    private $data;

    /** @param null|ResourceCollection|ResourceIdentifierCollection|ResourceIdentifierInterface|ResourceInterface $data */
    public function __construct($data)
    {
        $this->makeSureDataIsValid($data);
        $this->data = $data;
    }

    public function isResource(): bool
    {
        return $this->data instanceof ResourceInterface;
    }

    public function isResourceIdentifier(): bool
    {
        return $this->data instanceof ResourceIdentifierInterface;
    }

    public function isResourceCollection(): bool
    {
        return $this->data instanceof ResourceCollectionInterface;
    }

    public function isResourceIdentifierCollection(): bool
    {
        return $this->data instanceof ResourceIdentifierCollectionInterface;
    }

    public function isEmpty(): bool
    {
        return true === empty($this->data);
    }

    public function getResource(): ResourceInterface
    {
        $data = $this->data;
        if (true !== $this->isResource()) {
            throw new \DomainException('Data is not Resource');
        }
        /** @var ResourceInterface $data */

        return $data;
    }

    public function getResourceCollection(): ResourceCollectionInterface
    {
        $data = $this->data;
        if (true !== $this->isResourceCollection()) {
            throw new \DomainException('Data is not Resource Collection');
        }
        /** @var ResourceCollectionInterface $data */

        return $data;
    }

    public function getResourceIdentifier(): ResourceIdentifierInterface
    {
        $data = $this->data;
        if (true !== $this->isResourceIdentifier()) {
            throw new \DomainException('Data is not Resource Identifier');
        }
        /** @var ResourceIdentifierInterface $data */

        return $data;
    }

    public function getResourceIdentifierCollection(): ResourceIdentifierCollectionInterface
    {
        $data = $this->data;
        if (true !== $this->isResourceIdentifierCollection()) {
            throw new \DomainException('Data is not Resource Identifier Collection');
        }
        /** @var ResourceIdentifierCollectionInterface $data */

        return $data;
    }

    /**
     * Primary data MUST be either:
     * - a single resource object, a single resource identifier object, or null, for requests that target single resources
     * - an array of resource objects, an array of resource identifier objects, or an empty [[]], for requests that target resource collections.
     *
     * @param mixed $data
     */
    private function makeSureDataIsValid($data): void
    {
        // or null, for requests that target single resources
        if (null === $data) {
            return;
        }

        // or an empty [[]], for requests that target resource collections
        if ([] === $data) {
            return;
        }

        // a single resource object
        if (true === ($data instanceof ResourceInterface)) {
            return;
        }

        // a single resource identifier object
        if (true === ($data instanceof ResourceIdentifierInterface)) {
            return;
        }

        // an array of resource objects
        if (true === ($data instanceof ResourceCollectionInterface)) {
            return;
        }

        // an array of resource identifier objects
        if (true === ($data instanceof ResourceIdentifierCollectionInterface)) {
            return;
        }

        throw new \InvalidArgumentException('Invalid data provided');
    }
}
