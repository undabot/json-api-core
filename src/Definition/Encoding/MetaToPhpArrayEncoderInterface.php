<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

interface MetaToPhpArrayEncoderInterface
{
    public function encode(MetaInterface $meta);
}
