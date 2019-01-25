<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;

interface LinkCollectionPhpArrayEncoderInterface
{
    public function encode(LinkCollectionInterface $linkCollection);
}
