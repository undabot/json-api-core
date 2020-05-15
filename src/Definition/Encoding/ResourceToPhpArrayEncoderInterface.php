<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

interface ResourceToPhpArrayEncoderInterface
{
    public function encode(ResourceInterface $resource);
}
