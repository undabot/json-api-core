<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;

interface PhpArrayToLinkCollectionEncoderInterface
{
    public function encode(array $links): LinkCollectionInterface;
}
