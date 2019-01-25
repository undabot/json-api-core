<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Document;

use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface DocumentDataInterface
{
    public function isResource(): bool;

    public function isResourceIdentifier(): bool;

    public function isResourceCollection(): bool;

    public function isResourceIdentifierCollection(): bool;

    public function isEmpty(): bool;

    public function getResource(): ResourceInterface;

    public function getResourceCollection(): ResourceCollectionInterface;

    public function getResourceIdentifier(): ResourceIdentifierInterface;

    public function getResourceIdentifierCollection(): ResourceIdentifierCollectionInterface;
}
