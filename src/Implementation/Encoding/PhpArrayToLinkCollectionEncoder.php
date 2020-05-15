<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToLinkCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;

class PhpArrayToLinkCollectionEncoder implements PhpArrayToLinkCollectionEncoderInterface
{
    public function encode(array $links): LinkCollectionInterface
    {
        throw new \RuntimeException('Not implemented');
        // @todo implement
    }

    public function decodeLinkObject(string $name, string $url): LinkInterface
    {
        throw new \RuntimeException('Not implemented');
        // @todo implement
    }
}
