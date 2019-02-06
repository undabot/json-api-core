<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Meta\Meta;
use Undabot\JsonApi\Model\Meta\MetaInterface;

class PhpArrayToMetaEncoder implements PhpArrayToMetaEncoderInterface
{
    public function decode(array $meta): MetaInterface
    {
        return new Meta($meta);
    }
}
