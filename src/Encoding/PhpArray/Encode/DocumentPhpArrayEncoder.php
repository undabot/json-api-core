<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Document\DocumentInterface;

class DocumentPhpArrayEncoder implements DocumentPhpArrayEncoderInterface
{
    /** @var DocumentDataPhpArrayEncoderInterface */
    private $documentDataPhpArrayEncoder;

    /** @var ErrorCollectionPhpArrayEncoderInterface */
    private $errorCollectionPhpArrayEncoder;

    /** @var MetaPhpArrayEncoderInterface */
    private $metaPhpArrayEncoder;

    /** @var LinkCollectionPhpArrayEncoderInterface */
    private $linkCollectionPhpArrayEncoder;

    /** @var ResourceCollectionPhpArrayEncoderInterface */
    private $resourceCollectionPhpArrayEncoder;

    public function __construct(
        DocumentDataPhpArrayEncoderInterface $documentDataPhpArrayEncoder,
        ErrorCollectionPhpArrayEncoderInterface $errorCollectionPhpArrayEncoder,
        MetaPhpArrayEncoderInterface $metaPhpArrayEncoder,
        LinkCollectionPhpArrayEncoderInterface $linkCollectionPhpArrayEncoder,
        ResourceCollectionPhpArrayEncoderInterface $resourceCollectionPhpArrayEncoder
    ) {
        $this->documentDataPhpArrayEncoder = $documentDataPhpArrayEncoder;
        $this->errorCollectionPhpArrayEncoder = $errorCollectionPhpArrayEncoder;
        $this->metaPhpArrayEncoder = $metaPhpArrayEncoder;
        $this->linkCollectionPhpArrayEncoder = $linkCollectionPhpArrayEncoder;
        $this->resourceCollectionPhpArrayEncoder = $resourceCollectionPhpArrayEncoder;
    }

    public function encode(DocumentInterface $document): array
    {
        $serializedDocument = [];

        if (null !== $document->getData()) {
            $serializedDocument['data'] = $this->documentDataPhpArrayEncoder->encode($document->getData());
        }

        if (null !== $document->getErrors()) {
            $serializedDocument['errors'] = $this->errorCollectionPhpArrayEncoder->encode($document->getErrors());
        }

        if (null !== $document->getMeta()) {
            $serializedDocument['meta'] = $this->metaPhpArrayEncoder->encode($document->getMeta());
        }

        if (null !== $document->getJsonApiMeta()) {
            $serializedDocument['jsonapi'] = $this->metaPhpArrayEncoder->encode($document->getJsonApiMeta());
        }

        if (null !== $document->getLinks()) {
            $serializedDocument['links'] = $this->linkCollectionPhpArrayEncoder->encode($document->getLinks());
        }

        if (null !== $document->getIncluded()) {
            $serializedDocument['included'] = $this->resourceCollectionPhpArrayEncoder->encode($document->getIncluded());
        }

        return $serializedDocument;
    }
}
