<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Link\LinkInterface;

class LinkCollectionPhpArrayEncoder implements LinkCollectionPhpArrayEncoderInterface
{
    /** @var LinkPhpArrayEncoderInterface */
    private $linkPhpArrayEncoder;

    public function __construct(LinkPhpArrayEncoderInterface $linkPhpArrayEncoder)
    {
        $this->linkPhpArrayEncoder = $linkPhpArrayEncoder;
    }

    public function encode(LinkCollectionInterface $linkCollection): array
    {
        $links = [];

        /** @var LinkInterface $link */
        foreach ($linkCollection as $link) {
            $links[$link->getName()] = $this->linkPhpArrayEncoder->encode($link);
        }

        return $links;
    }
}
