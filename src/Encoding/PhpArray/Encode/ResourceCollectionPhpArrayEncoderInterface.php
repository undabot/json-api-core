<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

interface ResourceCollectionPhpArrayEncoderInterface
{
    public function encode(ResourceCollectionInterface $resource);
}
