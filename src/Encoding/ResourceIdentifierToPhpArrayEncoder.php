<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

class ResourceIdentifierToPhpArrayEncoder implements ResourceIdentifierToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaPhpArrayEncoder;

    public function __construct(MetaToPhpArrayEncoderInterface $metaPhpArrayEncoder)
    {
        $this->metaPhpArrayEncoder = $metaPhpArrayEncoder;
    }

    public function encode(ResourceIdentifierInterface $resourceIdentifier)
    {
        $serializedResourceIdentifier = [
            'type' => $resourceIdentifier->getType(),
            'id' => $resourceIdentifier->getId(),
        ];

        if (null !== $resourceIdentifier->getMeta()) {
            $serializedResourceIdentifier['meta'] = $this->metaPhpArrayEncoder->encode($resourceIdentifier->getMeta());
        }

        return $serializedResourceIdentifier;
    }
}
