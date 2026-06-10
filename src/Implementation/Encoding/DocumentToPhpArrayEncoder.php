<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\DocumentDataToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\DocumentToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ErrorCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Document\DocumentInterface;

class DocumentToPhpArrayEncoder implements DocumentToPhpArrayEncoderInterface
{
    public function __construct(private readonly DocumentDataToPhpArrayEncoderInterface $documentDataEncoder, private readonly ErrorCollectionToPhpArrayEncoderInterface $errorCollectionEncoder, private readonly MetaToPhpArrayEncoderInterface $metaEncoder, private readonly LinkCollectionToPhpArrayEncoderInterface $linkCollectionEncoder, private readonly ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionEncoder) {}

    public function encode(DocumentInterface $document): array
    {
        $serializedDocument = [];

        if (null !== $document->getJsonApiMeta()) {
            $serializedDocument['jsonapi'] = $this->metaEncoder->encode($document->getJsonApiMeta());
        }

        if (null !== $document->getErrors()) {
            $serializedDocument['errors'] = $this->errorCollectionEncoder->encode($document->getErrors());
        }

        if (null !== $document->getMeta()) {
            $serializedDocument['meta'] = $this->metaEncoder->encode($document->getMeta());
        }

        if (null !== $document->getLinks()) {
            $serializedDocument['links'] = $this->linkCollectionEncoder->encode($document->getLinks());
        }

        if (null !== $document->getData()) {
            $serializedDocument['data'] = $this->documentDataEncoder->encode($document->getData());
        }

        if (null !== $document->getIncluded()) {
            $serializedDocument['included'] = $this->resourceCollectionEncoder->encode($document->getIncluded());
        }

        return $serializedDocument;
    }
}
