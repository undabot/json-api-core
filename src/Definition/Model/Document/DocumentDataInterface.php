<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Document;

use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

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
