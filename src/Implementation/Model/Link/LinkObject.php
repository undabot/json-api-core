<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Link;

use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

final class LinkObject implements LinkMemberInterface
{
    /** @var string */
    private $href;

    /** @var null|MetaInterface */
    private $meta;

    public function __construct(string $href, ?MetaInterface $meta)
    {
        $this->href = $href;
        $this->meta = $meta;
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
