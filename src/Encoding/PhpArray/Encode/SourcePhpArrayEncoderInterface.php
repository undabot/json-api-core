<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Source\SourceInterface;

interface SourcePhpArrayEncoderInterface
{
    public function encode(SourceInterface $source);
}
