<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

interface MetaToPhpArrayEncoderInterface
{
    /** @return array<string,mixed> */
    public function encode(MetaInterface $meta): array;
}
