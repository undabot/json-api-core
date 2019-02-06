<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

interface ResourceCollectionToPhpArrayEncoderInterface
{
    public function encode(ResourceCollectionInterface $resource);
}
