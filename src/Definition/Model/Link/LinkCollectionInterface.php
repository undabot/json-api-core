<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Link;

use IteratorAggregate;

interface LinkCollectionInterface extends IteratorAggregate
{
    public function hasLink(string $linkName): bool;

    public function getLink(string $linkName): ?LinkInterface;

    public function getLinkNames(): array;

    public function getLinks(): array;
}
