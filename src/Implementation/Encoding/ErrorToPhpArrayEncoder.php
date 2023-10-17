<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\SourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;

/** @psalm-suppress UnusedClass */
class ErrorToPhpArrayEncoder implements ErrorToPhpArrayEncoderInterface
{
    private LinkToPhpArrayEncoderInterface $linkEncoder;

    private SourceToPhpArrayEncoderInterface $sourceEncoder;

    private MetaToPhpArrayEncoderInterface $metaEncoder;

    public function __construct(
        LinkToPhpArrayEncoderInterface $linkEncoder,
        SourceToPhpArrayEncoderInterface $sourceEncoder,
        MetaToPhpArrayEncoderInterface $metaEncoder
    ) {
        $this->linkEncoder = $linkEncoder;
        $this->sourceEncoder = $sourceEncoder;
        $this->metaEncoder = $metaEncoder;
    }

    /** @return array<string,mixed> */
    public function encode(ErrorInterface $error): array
    {
        $serializedError = [];
        $id = $error->getId();
        if (null !== $id) {
            $serializedError['id'] = $id;
        }

        $aboutLink = $error->getAboutLink();
        if (null !== $aboutLink) {
            $serializedError['links'] = $this->linkEncoder->encode($aboutLink);
        }

        $status = $error->getStatus();
        if (null !== $status) {
            $serializedError['status'] = $status;
        }

        $code = $error->getCode();
        if (null !== $code) {
            $serializedError['code'] = $code;
        }

        $title = $error->getTitle();
        if (null !== $title) {
            $serializedError['title'] = $title;
        }

        $detail = $error->getDetail();
        if (null !== $detail) {
            $serializedError['detail'] = $detail;
        }

        $source = $error->getSource();
        if (null !== $source) {
            $serializedError['source'] = $this->sourceEncoder->encode($source);
        }

        $meta = $error->getMeta();
        if (null !== $meta) {
            $serializedError['meta'] = $this->metaEncoder->encode($meta);
        }

        return $serializedError;
    }
}
