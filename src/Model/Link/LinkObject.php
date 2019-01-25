<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Link;

use Undabot\JsonApi\Model\Meta\Meta;

final class LinkObject implements LinkMemberInterface
{
    /** @var string */
    private $href;

    /** @var Meta|null */
    private $meta;

    public function __construct(string $href, ?Meta $meta)
    {
        $this->href = $href;
        $this->meta = $meta;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getMeta(): ?Meta
    {
        return $this->meta;
    }
}
