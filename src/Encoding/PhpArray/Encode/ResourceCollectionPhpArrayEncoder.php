<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

class ResourceCollectionPhpArrayEncoder implements ResourceCollectionPhpArrayEncoderInterface
{
    /** @var ResourcePhpArrayEncoderInterface */
    private $resourcePhpArrayEncoder;

    public function __construct(ResourcePhpArrayEncoderInterface $resourcePhpArrayEncoder)
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
