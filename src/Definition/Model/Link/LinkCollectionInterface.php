<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Link;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,LinkInterface>
 */
interface LinkCollectionInterface extends \IteratorAggregate
{
    /** @psalm-suppress PossiblyUnusedMethod */
    public function hasLink(string $linkName): bool;

    /** @psalm-suppress PossiblyUnusedMethod */
    public function getLink(string $linkName): ?LinkInterface;

    /** @return string[] */
    public function getLinkNames(): array;

    /**
     * @psalm-suppress PossiblyUnusedMethod
     *
     * @return LinkInterface[]
     */
    public function getLinks(): array;
}
