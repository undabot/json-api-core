<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

class ResourceIdentifierToPhpArrayEncoder implements ResourceIdentifierToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaToPhpArrayEncoder;

    public function __construct(MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder)
    {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
    }

    public function encode(ResourceIdentifierInterface $resourceIdentifier)
    {
        $serializedResourceIdentifier = [
            'type' => $resourceIdentifier->getType(),
            'id' => $resourceIdentifier->getId(),
        ];

        if (null !== $resourceIdentifier->getMeta()) {
            $serializedResourceIdentifier['meta'] = $this->metaToPhpArrayEncoder->encode($resourceIdentifier->getMeta());
        }

        return $serializedResourceIdentifier;
    }
}
