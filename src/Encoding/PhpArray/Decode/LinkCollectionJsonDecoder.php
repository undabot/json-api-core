<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;

class LinkCollectionJsonDecoder implements LinkCollectionJsonDecoderInterface
{
    public function decode(array $links): LinkCollectionInterface
    {
        // @todo implement
    }

    public function decodeLinkObject(array $link)
    {
        // @todo implement
    }
}
