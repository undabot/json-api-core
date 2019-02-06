<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Link\LinkInterface;

class LinkCollectionToPhpArrayEncoder implements LinkCollectionToPhpArrayEncoderInterface
{
    /** @var LinkToPhpArrayEncoderInterface */
    private $linkToPhpArrayEncoder;

    public function __construct(LinkToPhpArrayEncoderInterface $linkToPhpArrayEncoder)
    {
        $this->linkToPhpArrayEncoder = $linkToPhpArrayEncoder;
    }

    public function encode(LinkCollectionInterface $linkCollection): array
    {
        $links = [];

        /** @var LinkInterface $link */
        foreach ($linkCollection as $link) {
            $links[$link->getName()] = $this->linkToPhpArrayEncoder->encode($link);
        }

        return $links;
    }
}
