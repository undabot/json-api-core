<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\DocumentDataToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;

class DocumentDataToPhpArrayEncoder implements DocumentDataToPhpArrayEncoderInterface
{
    public function __construct(private readonly ResourceToPhpArrayEncoderInterface $resourceEncoder, private readonly ResourceCollectionToPhpArrayEncoderInterface $resourceCollectionEncoder, private readonly ResourceIdentifierToPhpArrayEncoderInterface $resourceIdentifierEncoder, private readonly ResourceIdentifierCollectionToPhpArrayEncoderInterface $resourceIdentifierCollectionEncoder) {}

    public function encode(DocumentDataInterface $documentData): ?array
    {
        if ($documentData->isResource()) {
            return $this->resourceEncoder->encode($documentData->getResource());
        }

        if ($documentData->isResourceCollection()) {
            return $this->resourceCollectionEncoder->encode($documentData->getResourceCollection());
        }

        if ($documentData->isResourceIdentifier()) {
            return $this->resourceIdentifierEncoder->encode($documentData->getResourceIdentifier());
        }

        if ($documentData->isResourceIdentifierCollection()) {
            return $this->resourceIdentifierCollectionEncoder
                ->encode($documentData->getResourceIdentifierCollection());
        }

        return null;
    }
}
