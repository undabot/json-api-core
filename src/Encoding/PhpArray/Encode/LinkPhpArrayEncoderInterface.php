<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Link\LinkInterface;

interface LinkPhpArrayEncoderInterface
{
    public function encode(LinkInterface $link);
}
