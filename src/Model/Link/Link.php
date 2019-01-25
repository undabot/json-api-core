<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Link;

use DomainException;
use InvalidArgumentException;

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

    private function makeSureNameIsValid(string $name): void
    {
        if (false === in_array($name, LinkNamesEnum::getValues())) {
            throw new InvalidArgumentException("Invalid link name {$name}");
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function returnLinkIf(bool $condition, string $errorMessage)
    {
        if (true !== $condition) {
            throw new DomainException($errorMessage);
        }

        return $this->link;
    }

    public function isLinkObject(): bool
    {
        return $this->link instanceof LinkObject;
    }

    public function getLinkObject(): ?LinkObject
    {
        return $this->returnLinkIf($this->isLinkObject(), 'Link is not LinkObject');
    }

    public function isLinkUrl(): bool
    {
        return $this->link instanceof LinkUrl;
    }

    public function getLinkUrl(): ?LinkUrl
    {
        return $this->returnLinkIf($this->isLinkUrl(), 'Link is not LinkUrl');
    }
}
