<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Link\LinkInterface;

interface LinkToPhpArrayEncoderInterface
{
    public function encode(LinkInterface $link);
}
