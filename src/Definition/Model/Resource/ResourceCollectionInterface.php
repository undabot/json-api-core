<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,ResourceInterface>
 */
interface ResourceCollectionInterface extends IteratorAggregate
{
    /**
     * @return ResourceInterface[] $resources
     */
    public function getResources(): array;
}
