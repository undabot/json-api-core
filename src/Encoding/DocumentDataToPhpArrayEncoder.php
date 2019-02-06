<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Document\DocumentDataInterface;

class DocumentDataToPhpArrayEncoder implements DocumentDataToPhpArrayEncoderInterface
{
    /** @var ResourceToPhpArrayEncoderInterface */
    private $resourceToPhpArrayEncoder;

    /** @var ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionToPhpArrayEncoder;

    /** @var ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierToPhpArrayEncoder;

    /** @var ResourceIdentifierCollectionToPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionToPhpArrayEncoder;

    public function __construct(
        ResourceToPhpArrayEncoderInterface $resourceToPhpArrayEncoder,
        ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionToPhpArrayEncoder,
        ResourceIdentifierToPhpArrayEncoderInterface $resourceIdentifierToPhpArrayEncoder,
        ResourceIdentifierCollectionToPhpArrayEncoderInterface $resourceIdentifierCollectionToPhpArrayEncoder
    ) {
        $this->resourceToPhpArrayEncoder = $resourceToPhpArrayEncoder;
        $this->resourceCollectionToPhpArrayEncoder = $resourceCollectionToPhpArrayEncoder;
        $this->resourceIdentifierToPhpArrayEncoder = $resourceIdentifierToPhpArrayEncoder;
        $this->resourceIdentifierCollectionToPhpArrayEncoder = $resourceIdentifierCollectionToPhpArrayEncoder;
    }

    public function encode(DocumentDataInterface $documentData): ?array
    {
        if ($documentData->isResource()) {
            return $this->resourceToPhpArrayEncoder->encode($documentData->getResource());
        }

        if ($documentData->isResourceCollection()) {
            return $this->resourceCollectionToPhpArrayEncoder->encode($documentData->getResourceCollection());
        }

        if ($documentData->isResourceIdentifier()) {
            return $this->resourceIdentifierToPhpArrayEncoder->encode($documentData->getResourceIdentifier());
        }

        if ($documentData->isResourceIdentifierCollection()) {
            return $this->resourceIdentifierCollectionToPhpArrayEncoder->encode($documentData->getResourceIdentifierCollection());
        }

        return null;
    }
}
