<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\LinkCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;

/** @psalm-suppress UnusedClass */
class LinkCollectionToPhpArrayEncoder implements LinkCollectionToPhpArrayEncoderInterface
{
    private LinkToPhpArrayEncoderInterface $linkEncoder;

    public function __construct(LinkToPhpArrayEncoderInterface $linkEncoder)
    {
        $this->linkEncoder = $linkEncoder;
    }

    /**
     * @return array<string,mixed>
     */
    public function encode(LinkCollectionInterface $linkCollection): array
    {
        $links = [];

        foreach ($linkCollection as $link) {
            $links[$link->getName()] = $this->linkEncoder->encode($link);
        }

        return $links;
    }
}
