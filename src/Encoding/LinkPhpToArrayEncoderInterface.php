<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Link\LinkInterface;

interface LinkPhpToArrayEncoderInterface
{
    public function encode(LinkInterface $link);
}
