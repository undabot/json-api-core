<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Implementation\Model\Meta\Meta;

class PhpArrayToMetaEncoder implements PhpArrayToMetaEncoderInterface
{
    public function decode(array $meta): MetaInterface
    {
        return new Meta($meta);
    }
}
