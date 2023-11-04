<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;

/** @psalm-suppress UnusedClass */
class ResourceCollectionToPhpArrayEncoder implements ResourceCollectionToPhpArrayEncoderInterface
{
    private ResourceToPhpArrayEncoderInterface $resourceToPhpArrayEncoder;

    public function __construct(ResourceToPhpArrayEncoderInterface $resourceToPhpArrayEncoder)
    {
        $this->resourceToPhpArrayEncoder = $resourceToPhpArrayEncoder;
    }

    /** @return array<int,array<string,mixed>> */
    public function encode(ResourceCollectionInterface $resources): array
    {
        $resourcesArray = [];

        foreach ($resources as $resource) {
            $resourcesArray[] = $this->resourceToPhpArrayEncoder->encode($resource);
        }

        return $resourcesArray;
    }
}
