<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Model\Meta\MetaInterface;

interface MetaJsonDecoderInterface
{
    public function decode(array $meta): MetaInterface;
}
