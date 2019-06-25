<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Document\DocumentInterface;

class DocumentToPhpArrayEncoder implements DocumentToPhpArrayEncoderInterface
{
    /** @var DocumentDataToPhpArrayEncoderInterface */
    private $documentDataToPhpArrayEncoder;

    /** @var ErrorCollectionToPhpArrayEncoderInterface */
    private $errorCollectionToPhpArrayEncoder;

    /** @var MetaToPhpArrayEncoderInterface */
    private $metaToPhpArrayEncoder;

    /** @var LinkCollectionToPhpArrayEncoderInterface */
    private $linkCollectionToPhpArrayEncoder;

    /** @var ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionToPhpArrayEncoder;

    public function __construct(
        DocumentDataToPhpArrayEncoderInterface $documentDataToPhpArrayEncoder,
        ErrorCollectionToPhpArrayEncoderInterface $errorCollectionToPhpArrayEncoder,
        MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder,
        LinkCollectionToPhpArrayEncoderInterface $linkCollectionToPhpArrayEncoder,
        ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionToPhpArrayEncoder
    ) {
        $this->documentDataToPhpArrayEncoder = $documentDataToPhpArrayEncoder;
        $this->errorCollectionToPhpArrayEncoder = $errorCollectionToPhpArrayEncoder;
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
        $this->linkCollectionToPhpArrayEncoder = $linkCollectionToPhpArrayEncoder;
        $this->resourceCollectionToPhpArrayEncoder = $resourceCollectionToPhpArrayEncoder;
    }

    public function encode(DocumentInterface $document): array
    {
        $serializedDocument = [];

        if (null !== $document->getJsonApiMeta()) {
            $serializedDocument['jsonapi'] = $this->metaToPhpArrayEncoder->encode($document->getJsonApiMeta());
        }

        if (null !== $document->getErrors()) {
            $serializedDocument['errors'] = $this->errorCollectionToPhpArrayEncoder->encode($document->getErrors());
        }

        if (null !== $document->getMeta()) {
            $serializedDocument['meta'] = $this->metaToPhpArrayEncoder->encode($document->getMeta());
        }

        if (null !== $document->getLinks()) {
            $serializedDocument['links'] = $this->linkCollectionToPhpArrayEncoder->encode($document->getLinks());
        }

        if (null !== $document->getData()) {
            $serializedDocument['data'] = $this->documentDataToPhpArrayEncoder->encode($document->getData());
        }

        if (null !== $document->getIncluded()) {
            $serializedDocument['included'] = $this->resourceCollectionToPhpArrayEncoder->encode($document->getIncluded());
        }

        return $serializedDocument;
    }
}
