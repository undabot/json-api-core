<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Link;

final class LinkUrl implements LinkMemberInterface
{
    /** @var string */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
