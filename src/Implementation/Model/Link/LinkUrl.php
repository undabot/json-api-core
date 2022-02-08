<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Link;

use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;

final class LinkUrl implements LinkMemberInterface
{
    public function __construct(private string $url)
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
