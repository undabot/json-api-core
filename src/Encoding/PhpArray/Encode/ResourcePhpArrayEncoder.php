<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\ResourceInterface;

class ResourcePhpArrayEncoder implements ResourcePhpArrayEncoderInterface
{
    /** @var MetaPhpArrayEncoderInterface */
    private $metaPhpArrayEncoder;

    /** @var RelationshipCollectionPhpArrayEncoderInterface */
    private $relationshipCollectionPhpArrayEncoder;

    /** @var LinkPhpArrayEncoderInterface */
    private $linkPhpArrayEncoder;

    /** @var AttributeCollectionPhpArrayEncoderInterface */
    private $attributeCollectionPhpArrayEncoder;

    public function __construct(
        MetaPhpArrayEncoderInterface $metaPhpArrayEncoder,
        RelationshipCollectionPhpArrayEncoderInterface $relationshipCollectionPhpArrayEncoder,
        LinkPhpArrayEncoderInterface $linkPhpArrayEncoder,
        AttributeCollectionPhpArrayEncoderInterface $attributeCollectionPhpArrayEncoder
    ) {
        $this->metaPhpArrayEncoder = $metaPhpArrayEncoder;
        $this->relationshipCollectionPhpArrayEncoder = $relationshipCollectionPhpArrayEncoder;
        $this->linkPhpArrayEncoder = $linkPhpArrayEncoder;
        $this->attributeCollectionPhpArrayEncoder = $attributeCollectionPhpArrayEncoder;
    }

    public function encode(ResourceInterface $resource): array
    {
        $serializedResource = [
            'type' => $resource->getType(),
            'id' => $resource->getId(),
        ];

        if (null !== $resource->getAttributes()) {
            $serializedResource['attributes'] = $this->attributeCollectionPhpArrayEncoder->encode($resource->getAttributes());
        }

        if (null !== $resource->getMeta()) {
            $serializedResource['meta'] = $this->metaPhpArrayEncoder->encode($resource->getMeta());
        }

        if (null !== $resource->getSelfUrl()) {
            $serializedResource['links'] = [
                'self' => $this->linkPhpArrayEncoder->encode($resource->getSelfUrl()),
            ];
        }

        if (null !== $resource->getRelationships()) {
            $serializedResource['relationships'] = $this->relationshipCollectionPhpArrayEncoder->encode($resource->getRelationships());
        }

        return $serializedResource;
    }
}
