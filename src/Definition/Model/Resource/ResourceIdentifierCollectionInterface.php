<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,ResourceIdentifierInterface>
 */
interface ResourceIdentifierCollectionInterface extends \IteratorAggregate
{
    /**
     * @return ResourceIdentifierInterface[]
     */
    public function getResourceIdentifiers(): array;
}
