<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\LinkCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;

class LinkCollectionToPhpArrayEncoder implements LinkCollectionToPhpArrayEncoderInterface
{
    /** @var LinkToPhpArrayEncoderInterface */
    private $linkEncoder;

    public function __construct(LinkToPhpArrayEncoderInterface $linkEncoder)
    {
        $this->linkEncoder = $linkEncoder;
    }

    public function encode(LinkCollectionInterface $linkCollection): array
    {
        $links = [];

        /** @var LinkInterface $link */
        foreach ($linkCollection as $link) {
            $links[$link->getName()] = $this->linkEncoder->encode($link);
        }

        return $links;
    }
}
