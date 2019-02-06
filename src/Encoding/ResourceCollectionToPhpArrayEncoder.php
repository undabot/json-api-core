<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

class ResourceCollectionToPhpArrayEncoder implements ResourceCollectionToPhpArrayEncoderInterface
{
    /** @var ResourceToPhpArrayEncoderInterface */
    private $resourceToPhpArrayEncoder;

    public function __construct(ResourceToPhpArrayEncoderInterface $resourceToPhpArrayEncoder)
    {
        $this->resourceToPhpArrayEncoder = $resourceToPhpArrayEncoder;
    }

    public function encode(ResourceCollectionInterface $resourceCollection): array
    {
        $resources = [];

        foreach ($resourceCollection as $resource) {
            $resources[] = $this->resourceToPhpArrayEncoder->encode($resource);
        }

        return $resources;
    }
}
