<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource;

interface ResourceCollectionInterface extends \IteratorAggregate
{
    public function getResources(): array;
}
