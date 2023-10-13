<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Link;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,LinkInterface>
 */
interface LinkCollectionInterface extends \IteratorAggregate
{
    public function hasLink(string $linkName): bool;

    public function getLink(string $linkName): ?LinkInterface;

    /** @return string[] */
    public function getLinkNames(): array;

    /** @return LinkInterface[] */
    public function getLinks(): array;
}
