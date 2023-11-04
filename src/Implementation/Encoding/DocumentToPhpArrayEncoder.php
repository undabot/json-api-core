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

/** @psalm-suppress UnusedClass */
class DocumentToPhpArrayEncoder implements DocumentToPhpArrayEncoderInterface
{
    private DocumentDataToPhpArrayEncoderInterface $documentDataEncoder;

    private ErrorCollectionToPhpArrayEncoderInterface $errorCollectionEncoder;

    private MetaToPhpArrayEncoderInterface $metaEncoder;

    private LinkCollectionToPhpArrayEncoderInterface $linkCollectionEncoder;

    private ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionEncoder;

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

    /** @return array<string,mixed> */
    public function encode(DocumentInterface $document): array
    {
        $serializedDocument = [];

        $jsonApiMeta = $document->getJsonApiMeta();
        if (null !== $jsonApiMeta) {
            $serializedDocument['jsonapi'] = $this->metaEncoder->encode($jsonApiMeta);
        }

        $errors = $document->getErrors();
        if (null !== $errors) {
            $serializedDocument['errors'] = $this->errorCollectionEncoder->encode($errors);
        }

        $meta = $document->getMeta();
        if (null !== $meta) {
            $serializedDocument['meta'] = $this->metaEncoder->encode($meta);
        }

        $links = $document->getLinks();
        if (null !== $links) {
            $serializedDocument['links'] = $this->linkCollectionEncoder->encode($links);
        }

        $data = $document->getData();
        if (null !== $data) {
            $serializedDocument['data'] = $this->documentDataEncoder->encode($data);
        }

        $included = $document->getIncluded();
        if (null !== $included) {
            $serializedDocument['included'] = $this->resourceCollectionEncoder->encode($included);
        }

        return $serializedDocument;
    }
}
