<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;

class ResourceIdentifierCollectionToPhpArrayEncoder implements ResourceIdentifierCollectionToPhpArrayEncoderInterface
{
    /** @var ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierPhpArrayEncoder;

    public function __construct(ResourceIdentifierToPhpArrayEncoderInterface $resourceIdentifierPhpArrayEncoder)
    {
        $this->resourceIdentifierPhpArrayEncoder = $resourceIdentifierPhpArrayEncoder;
    }

    public function encode(ResourceIdentifierCollectionInterface $resourceIdentifierCollection): array
    {
        $resourceIdentifiers = [];

        foreach ($resourceIdentifierCollection as $resourceIdentifier) {
            $resourceIdentifiers[] = $this->resourceIdentifierPhpArrayEncoder->encode($resourceIdentifier);
        }

        return $resourceIdentifiers;
    }
}
