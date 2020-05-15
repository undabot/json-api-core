<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;

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
