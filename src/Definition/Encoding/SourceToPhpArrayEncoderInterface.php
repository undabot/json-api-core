<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

interface SourceToPhpArrayEncoderInterface
{
    /**
     * @return array<string,null|string>
     */
    public function encode(SourceInterface $source): array;
}
