<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Link;

use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkNamesEnum;

final class Link implements LinkInterface
{
    /** @var string */
    private $name;

    /** @var LinkMemberInterface */
    private $link;

    public function __construct(string $name, LinkMemberInterface $link)
    {
        $this->makeSureNameIsValid($name);
        $this->name = $name;
        $this->link = $link;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLink(): ?LinkMemberInterface
    {
        return $this->link;
    }

    public function isLinkUrl(): bool
    {
        return $this->link instanceof LinkUrl;
    }

    private function makeSureNameIsValid(string $name): void
    {
        if (false === \in_array($name, LinkNamesEnum::getValues(), true)) {
            throw new InvalidArgumentException("Invalid link name {$name}");
        }
    }
}
