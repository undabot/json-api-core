<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

class ResourceIdentifierPhpArrayEncoder implements ResourceIdentifierPhpArrayEncoderInterface
{
    /** @var MetaPhpArrayEncoderInterface */
    private $metaPhpArrayEncoder;

    public function __construct(MetaPhpArrayEncoderInterface $metaPhpArrayEncoder)
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
