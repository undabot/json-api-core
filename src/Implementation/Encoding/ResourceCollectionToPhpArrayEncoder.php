<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;

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
