<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

interface PhpArrayToMetaEncoderInterface
{
    public function decode(array $meta): MetaInterface;
}
