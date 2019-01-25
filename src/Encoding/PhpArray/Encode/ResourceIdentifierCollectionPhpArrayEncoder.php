<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;

class ResourceIdentifierCollectionPhpArrayEncoder implements ResourceIdentifierCollectionPhpArrayEncoderInterface
{
    /** @var ResourceIdentifierPhpArrayEncoderInterface */
    private $resourceIdentifierPhpArrayEncoder;

    public function __construct(ResourceIdentifierPhpArrayEncoderInterface $resourceIdentifierPhpArrayEncoder)
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
