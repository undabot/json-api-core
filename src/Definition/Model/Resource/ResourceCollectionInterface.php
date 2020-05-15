<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource;

use IteratorAggregate;

interface ResourceCollectionInterface extends IteratorAggregate
{
    public function getResources(): array;
}
