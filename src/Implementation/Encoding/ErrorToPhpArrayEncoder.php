<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\SourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;

class ErrorToPhpArrayEncoder implements ErrorToPhpArrayEncoderInterface
{
    /** @var LinkToPhpArrayEncoderInterface */
    private $linkEncoder;

    /** @var SourceToPhpArrayEncoderInterface */
    private $sourceEncoder;

    /** @var MetaToPhpArrayEncoderInterface */
    private $metaEncoder;

    public function __construct(
        LinkToPhpArrayEncoderInterface $linkEncoder,
        SourceToPhpArrayEncoderInterface $sourceEncoder,
        MetaToPhpArrayEncoderInterface $metaEncoder
    ) {
        $this->linkEncoder = $linkEncoder;
        $this->sourceEncoder = $sourceEncoder;
        $this->metaEncoder = $metaEncoder;
    }

    public function encode(ErrorInterface $error): array
    {
        $serializedError = [];

        if (null !== $error->getId()) {
            $serializedError['id'] = $error->getId();
        }

        if (null !== $error->getAboutLink()) {
            $serializedError['links'] = $this->linkEncoder->encode($error->getAboutLink());
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
            $serializedError['source'] = $this->sourceEncoder->encode($error->getSource());
        }

        if (null !== $error->getMeta()) {
            $serializedError['meta'] = $this->metaEncoder->encode($error->getMeta());
        }

        return $serializedError;
    }
}
