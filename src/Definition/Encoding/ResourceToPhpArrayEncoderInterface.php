<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

interface ResourceToPhpArrayEncoderInterface
{
    /** @return array<string,mixed> */
    public function encode(ResourceInterface $resource);
}
