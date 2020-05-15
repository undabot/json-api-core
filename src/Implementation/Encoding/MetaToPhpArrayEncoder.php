<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

class MetaToPhpArrayEncoder implements MetaToPhpArrayEncoderInterface
{
    public function encode(MetaInterface $meta): array
    {
        return $meta->getData();
    }
}
