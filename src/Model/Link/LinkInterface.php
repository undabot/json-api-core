<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Link;

interface LinkInterface
{
    public function getName(): string;

    public function isLinkObject(): bool;

    public function getLinkObject(): ?LinkObject;

    public function isLinkUrl(): bool;

    public function getLinkUrl(): ?LinkUrl;
}
