<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Meta\MetaInterface;

class MetaPhpArrayEncoder implements MetaPhpArrayEncoderInterface
{
    public function encode(MetaInterface $meta): array
    {
        return $meta->getData();
    }
}
