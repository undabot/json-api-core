<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Link;

use ArrayIterator;
use Assert\Assertion;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;

final class LinkCollection implements LinkCollectionInterface
{
    /** @var LinkInterface[] */
    private $links;

    public function __construct(array $links)
    {
        Assertion::allIsInstanceOf($links, LinkInterface::class);
        $this->links = $links;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function hasLink(string $linkName): bool
    {
        foreach ($this->links as $link) {
            if ($link->getName() === $linkName) {
                return true;
            }
        }

        return false;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->links);
    }

    public function getLink(string $linkName): ?LinkInterface
    {
        foreach ($this->links as $link) {
            if ($link->getName() === $linkName) {
                return $link;
            }
        }

        return null;
    }

    public function getLinkNames(): array
    {
        $linkNames = [];

        foreach ($this->links as $link) {
            $linkNames[] = $link->getName();
        }

        return $linkNames;
    }
}
