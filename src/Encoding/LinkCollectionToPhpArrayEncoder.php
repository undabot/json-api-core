<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Link\LinkInterface;

class LinkCollectionToPhpArrayEncoder implements LinkCollectionToPhpArrayEncoderInterface
{
    /** @var LinkPhpToArrayEncoderInterface */
    private $linkPhpArrayEncoder;

    public function __construct(LinkPhpToArrayEncoderInterface $linkPhpArrayEncoder)
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
