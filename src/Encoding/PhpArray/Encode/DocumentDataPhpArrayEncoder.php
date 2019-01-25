<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Document\DocumentDataInterface;

class DocumentDataPhpArrayEncoder implements DocumentDataPhpArrayEncoderInterface
{
    /** @var ResourcePhpArrayEncoderInterface */
    private $resourcePhpArrayEncoder;

    /** @var ResourceCollectionPhpArrayEncoderInterface */
    private $resourceCollectionPhpArrayEncoder;

    /** @var ResourceIdentifierPhpArrayEncoderInterface */
    private $resourceIdentifierPhpArrayEncoder;

    /** @var ResourceIdentifierCollectionPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionPhpArrayEncoder;

    public function __construct(
        ResourcePhpArrayEncoderInterface $resourcePhpArrayEncoder,
        ResourceCollectionPhpArrayEncoderInterface $resourceCollectionPhpArrayEncoder,
        ResourceIdentifierPhpArrayEncoderInterface $resourceIdentifierPhpArrayEncoder,
        ResourceIdentifierCollectionPhpArrayEncoderInterface $resourceIdentifierCollectionPhpArrayEncoder
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
