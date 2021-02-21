<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;

interface LinkCollectionToPhpArrayEncoderInterface
{
    public function encode(LinkCollectionInterface $linkCollection): array;
}
