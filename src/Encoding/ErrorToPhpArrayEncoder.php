<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Error\ErrorInterface;

class ErrorToPhpArrayEncoder implements ErrorToPhpArrayEncoderInterface
{
    /** @var LinkToPhpArrayEncoderInterface */
    private $linkToPhpArrayEncoder;

    /** @var SourceToPhpArrayEncoderInterface */
    private $sourceToPhpArrayEncoder;

    /** @var MetaToPhpArrayEncoder */
    private $metaToPhpArrayEncoder;

    public function __construct(
        LinkToPhpArrayEncoderInterface $linkToPhpArrayEncoder,
        SourceToPhpArrayEncoderInterface $sourceToPhpArrayEncoder,
        MetaToPhpArrayEncoder $metaToPhpArrayEncoder
    ) {
        $this->linkToPhpArrayEncoder = $linkToPhpArrayEncoder;
        $this->sourceToPhpArrayEncoder = $sourceToPhpArrayEncoder;
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
    }

    public function encode(ErrorInterface $error): array
    {
        $serializedError = [];

        if (null !== $error->getId()) {
            $serializedError['id'] = $error->getId();
        }

        if (null !== $error->getAboutLink()) {
            $serializedError['links'] = $this->linkToPhpArrayEncoder->encode($error->getAboutLink());
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
            $serializedError['source'] = $this->sourceToPhpArrayEncoder->encode($error->getSource());
        }

        if (null !== $error->getMeta()) {
            $serializedError['meta'] = $this->metaToPhpArrayEncoder->encode($error->getMeta());
        }

        return $serializedError;
    }
}
