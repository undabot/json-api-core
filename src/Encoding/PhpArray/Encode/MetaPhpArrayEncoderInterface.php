<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Meta\MetaInterface;

interface MetaPhpArrayEncoderInterface
{
    public function encode(MetaInterface $meta);
}
