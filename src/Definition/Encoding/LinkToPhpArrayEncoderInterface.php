<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Link\LinkInterface;

interface LinkToPhpArrayEncoderInterface
{
    /**
     * @return null|array<string,mixed>|string
     */
    public function encode(LinkInterface $link);
}
