<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Source\SourceInterface;

interface SourceToPhpArrayEncoderInterface
{
    public function encode(SourceInterface $source);
}
