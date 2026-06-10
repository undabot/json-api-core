<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource;

interface ResourceIdentifierCollectionInterface extends \IteratorAggregate
{
    public function getResourceIdentifiers(): array;
}
