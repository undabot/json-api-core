<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface ResourceToPhpArrayEncoderInterface
{
    public function encode(ResourceInterface $resource);
}
