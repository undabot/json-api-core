<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Document\DocumentDataInterface;

class DocumentDataToPhpArrayEncoder implements DocumentDataToPhpArrayEncoderInterface
{
    /** @var ResourceToPhpArrayEncoderInterface */
    private $resourcePhpArrayEncoder;

    /** @var ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionPhpArrayEncoder;

    /** @var ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierPhpArrayEncoder;

    /** @var ResourceIdentifierCollectionToPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionPhpArrayEncoder;

    public function __construct(
        ResourceToPhpArrayEncoderInterface $resourcePhpArrayEncoder,
        ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionPhpArrayEncoder,
        ResourceIdentifierToPhpArrayEncoderInterface $resourceIdentifierPhpArrayEncoder,
        ResourceIdentifierCollectionToPhpArrayEncoderInterface $resourceIdentifierCollectionPhpArrayEncoder
    ) {
        $this->resourcePhpArrayEncoder = $resourcePhpArrayEncoder;
        $this->resourceCollectionPhpArrayEncoder = $resourceCollectionPhpArrayEncoder;
        $this->resourceIdentifierPhpArrayEncoder = $resourceIdentifierPhpArrayEncoder;
        $this->resourceIdentifierCollectionPhpArrayEncoder = $resourceIdentifierCollectionPhpArrayEncoder;
    }

    public function encode(DocumentDataInterface $documentData): ?array
    {
        if ($documentData->isResource()) {
            return $this->resourcePhpArrayEncoder->encode($documentData->getResource());
        }

        if ($documentData->isResourceCollection()) {
            return $this->resourceCollectionPhpArrayEncoder->encode($documentData->getResourceCollection());
        }

        if ($documentData->isResourceIdentifier()) {
            return $this->resourceIdentifierPhpArrayEncoder->encode($documentData->getResourceIdentifier());
        }

        if ($documentData->isResourceIdentifierCollection()) {
            return $this->resourceIdentifierCollectionPhpArrayEncoder->encode($documentData->getResourceIdentifierCollection());
        }

        return null;
    }
}
