<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Error\ErrorInterface;

class ErrorToPhpArrayEncoder implements ErrorToPhpArrayEncoderInterface
{
    /** @var LinkToPhpArrayEncoderInterface */
    private $linkPhpArrayEncoder;

    /** @var SourceToPhpArrayEncoderInterface */
    private $sourcePhpArrayEncoder;

    /** @var MetaToPhpArrayEncoder */
    private $metaPhpArrayEncoder;

    public function __construct(
        LinkToPhpArrayEncoderInterface $linkPhpArrayEncoder,
        SourceToPhpArrayEncoderInterface $sourcePhpArrayEncoder,
        MetaToPhpArrayEncoder $metaPhpArrayEncoder
    ) {
        $this->linkPhpArrayEncoder = $linkPhpArrayEncoder;
        $this->sourcePhpArrayEncoder = $sourcePhpArrayEncoder;
        $this->metaPhpArrayEncoder = $metaPhpArrayEncoder;
    }

    public function encode(ErrorInterface $error): array
    {
        $serializedError = [];

        if (null !== $error->getId()) {
            $serializedError['id'] = $error->getId();
        }

        if (null !== $error->getAboutLink()) {
            $serializedError['links'] = $this->linkPhpArrayEncoder->encode($error->getAboutLink());
        }

        if (null !== $error->getStatus()) {
            $serializedError['status'] = $error->getStatus();
        }

        if (null !== $error->getCode()) {
            $serializedError['code'] = $error->getCode();
        }

        if (null !== $error->getTitle()) {
            $serializedError['title'] = $error->getTitle();
        }

        if (null !== $error->getDetail()) {
            $serializedError['detail'] = $error->getDetail();
        }

        if (null !== $error->getSource()) {
            $serializedError['source'] = $this->sourcePhpArrayEncoder->encode($error->getSource());
        }

        if (null !== $error->getMeta()) {
            $serializedError['meta'] = $this->metaPhpArrayEncoder->encode($error->getMeta());
        }

        return $serializedError;
    }
}
