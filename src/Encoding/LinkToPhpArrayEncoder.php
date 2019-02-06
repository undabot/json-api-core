<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Link\LinkInterface;
use Undabot\JsonApi\Model\Link\LinkObject;
use Undabot\JsonApi\Model\Link\LinkUrl;

class LinkToPhpArrayEncoder implements LinkToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoder */
    private $metaToPhpArrayEncoder;

    public function __construct(MetaToPhpArrayEncoder $metaToPhpArrayEncoder)
    {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
    }

    public function encode(LinkInterface $link)
    {
        if (true === $link->isLinkUrl() && $link->getLinkUrl() instanceof LinkUrl) {
            return $link->getLinkUrl()->getUrl();
        }

        if (true === $link->isLinkObject() && $link->getLinkObject() instanceof LinkObject) {
            return $this->encodeLinkObject($link->getLinkObject());
        }

        return null;
    }

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
