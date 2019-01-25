<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Model\Meta\Meta;
use Undabot\JsonApi\Model\Meta\MetaInterface;

class MetaJsonDecoder implements MetaJsonDecoderInterface
{
    public function decode(array $meta): MetaInterface
    {
        return new Meta($meta);
    }
}
