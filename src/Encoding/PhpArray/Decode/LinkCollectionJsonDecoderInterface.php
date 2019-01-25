<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;

interface LinkCollectionJsonDecoderInterface
{
    public function decode(array $links): LinkCollectionInterface;
}
