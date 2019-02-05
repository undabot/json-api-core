<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceInterface;

class ResourceToPhpArrayEncoder implements ResourceToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaPhpArrayEncoder;

    /** @var RelationshipCollectionToPhpArrayEncoderInterface */
    private $relationshipCollectionPhpArrayEncoder;

    /** @var LinkPhpToArrayEncoderInterface */
    private $linkPhpArrayEncoder;

    /** @var AttributeCollectionToPhpArrayEncoderInterface */
    private $attributeCollectionPhpArrayEncoder;

    public function __construct(
        MetaToPhpArrayEncoderInterface $metaPhpArrayEncoder,
        RelationshipCollectionToPhpArrayEncoderInterface $relationshipCollectionPhpArrayEncoder,
        LinkPhpToArrayEncoderInterface $linkPhpArrayEncoder,
        AttributeCollectionToPhpArrayEncoderInterface $attributeCollectionPhpArrayEncoder
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
