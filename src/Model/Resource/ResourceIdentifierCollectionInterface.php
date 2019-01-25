<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource;

use IteratorAggregate;

interface ResourceIdentifierCollectionInterface extends IteratorAggregate
{
    public function getResourceIdentifiers(): array;
}
