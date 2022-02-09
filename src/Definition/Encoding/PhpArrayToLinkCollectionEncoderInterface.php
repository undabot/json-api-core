<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;

interface PhpArrayToLinkCollectionEncoderInterface
{
    /** @param array<string,string> $links */
    public function encode(array $links): LinkCollectionInterface;
}
