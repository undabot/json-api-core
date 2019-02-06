<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

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
