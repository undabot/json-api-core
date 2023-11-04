<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Implementation\Model\Link\LinkObject;
use Undabot\JsonApi\Implementation\Model\Link\LinkUrl;

/** @psalm-suppress UnusedClass */
class LinkToPhpArrayEncoder implements LinkToPhpArrayEncoderInterface
{
    private MetaToPhpArrayEncoder $metaToPhpArrayEncoder;

    public function __construct(MetaToPhpArrayEncoder $metaToPhpArrayEncoder)
    {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
    }

    /**
     * @return null|array<string,mixed>|string
     */
    public function encode(LinkInterface $link)
    {
        $linkMember = $link->getLink();
        if (null === $linkMember) {
            return null;
        }

        if ($linkMember instanceof LinkUrl) {
            return $linkMember->getUrl();
        }

        if ($linkMember instanceof LinkObject) {
            return $this->encodeLinkObject($linkMember);
        }

        return null;
    }

    /**
     * @return array<string,mixed>
     */
    private function encodeLinkObject(LinkObject $linkObject): array
    {
        $serializedLinkObject = [];
        $serializedLinkObject['href'] = $linkObject->getHref();

        if (null !== $linkObject->getMeta()) {
            $serializedLinkObject['meta'] = $this->metaToPhpArrayEncoder->encode($linkObject->getMeta());
        }

        return $serializedLinkObject;
    }
}
