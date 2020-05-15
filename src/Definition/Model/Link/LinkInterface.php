<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Link;

interface LinkInterface
{
    public function getName(): string;

    public function getLink(): ?LinkMemberInterface;
}
