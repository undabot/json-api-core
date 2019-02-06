<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Meta\MetaInterface;

interface MetaToPhpArrayEncoderInterface
{
    public function encode(MetaInterface $meta);
}
