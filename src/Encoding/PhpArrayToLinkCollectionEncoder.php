<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;

class PhpArrayToLinkCollectionEncoder implements PhpArrayToLinkCollectionEncoderInterface
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
