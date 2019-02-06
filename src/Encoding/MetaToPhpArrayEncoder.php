<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Meta\MetaInterface;

class MetaToPhpArrayEncoder implements MetaToPhpArrayEncoderInterface
{
    public function encode(MetaInterface $meta): array
    {
        return $meta->getData();
    }
}
