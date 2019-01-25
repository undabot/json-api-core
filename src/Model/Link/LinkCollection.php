<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Link;

use ArrayIterator;
use InvalidArgumentException;

final class LinkCollection implements LinkCollectionInterface
{
    /** @var Link[] */
    private $links;

    public function __construct(array $links)
    {
        $this->makeSureAllLinksAreValid($links);
        $this->links = $links;
    }

    private function makeSureAllLinksAreValid(array $links): void
    {
        foreach ($links as $link) {
            if (false === ($link instanceof Link)) {
                $message = sprintf('Link expected, %s given', get_class($link));
                throw new InvalidArgumentException($message);
            }
        }
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
