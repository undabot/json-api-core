<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;

class ResourceIdentifierCollectionToPhpArrayEncoder implements ResourceIdentifierCollectionToPhpArrayEncoderInterface
{
    /** @var ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierToPhpArrayEncoder;

    public function __construct(ResourceIdentifierToPhpArrayEncoderInterface $resourceIdentifierToPhpArrayEncoder)
    {
        $this->resourceIdentifierToPhpArrayEncoder = $resourceIdentifierToPhpArrayEncoder;
    }

    public function encode(ResourceIdentifierCollectionInterface $resourceIdentifierCollection): array
    {
        $resourceIdentifiers = [];

        foreach ($resourceIdentifierCollection as $resourceIdentifier) {
            $resourceIdentifiers[] = $this->resourceIdentifierToPhpArrayEncoder->encode($resourceIdentifier);
        }

        return $resourceIdentifiers;
    }
}
