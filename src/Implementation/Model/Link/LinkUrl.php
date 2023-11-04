<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Link;

use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;

final class LinkUrl implements LinkMemberInterface
{
    /** @var string */
    private $url;

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
