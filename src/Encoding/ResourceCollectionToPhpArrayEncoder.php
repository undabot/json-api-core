<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

class ResourceCollectionToPhpArrayEncoder implements ResourceCollectionToPhpArrayEncoderInterface
{
    /** @var ResourceToPhpArrayEncoderInterface */
    private $resourcePhpArrayEncoder;

    public function __construct(ResourceToPhpArrayEncoderInterface $resourcePhpArrayEncoder)
    {
        $this->resourcePhpArrayEncoder = $resourcePhpArrayEncoder;
    }

    public function encode(ResourceCollectionInterface $resourceCollection): array
    {
        $resources = [];

        foreach ($resourceCollection as $resource) {
            $resources[] = $this->resourcePhpArrayEncoder->encode($resource);
        }

        return $resources;
    }
}
