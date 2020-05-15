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
    /** @var DocumentDataToPhpArrayEncoderInterface */
    private $documentDataEncoder;

    /** @var ErrorCollectionToPhpArrayEncoderInterface */
    private $errorCollectionEncoder;

    /** @var MetaToPhpArrayEncoderInterface */
    private $metaEncoder;

    /** @var LinkCollectionToPhpArrayEncoderInterface */
    private $linkCollectionEncoder;

    /** @var ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionEncoder;

    public function __construct(
        DocumentDataToPhpArrayEncoderInterface $documentDataEncoder,
        ErrorCollectionToPhpArrayEncoderInterface $errorCollectionEncoder,
        MetaToPhpArrayEncoderInterface $metaEncoder,
        LinkCollectionToPhpArrayEncoderInterface $linkCollectionEncoder,
        ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionEncoder
    ) {
        $this->documentDataEncoder = $documentDataEncoder;
        $this->errorCollectionEncoder = $errorCollectionEncoder;
        $this->metaEncoder = $metaEncoder;
        $this->linkCollectionEncoder = $linkCollectionEncoder;
        $this->resourceCollectionEncoder = $resourceCollectionEncoder;
    }

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
