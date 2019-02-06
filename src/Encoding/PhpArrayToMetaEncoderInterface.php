<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Meta\MetaInterface;

interface PhpArrayToMetaEncoderInterface
{
    public function decode(array $meta): MetaInterface;
}
