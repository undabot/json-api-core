<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Link;

use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

final class LinkObject implements LinkMemberInterface
{
    public function __construct(private string $href, private ?MetaInterface $meta)
    {
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }
}
