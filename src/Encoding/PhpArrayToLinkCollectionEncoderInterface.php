<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;

interface PhpArrayToLinkCollectionEncoderInterface
{
    public function decode(array $links): LinkCollectionInterface;
}
