<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\ResourceInterface;

class ResourceToPhpArrayEncoder implements ResourceToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaToPhpArrayEncoder;

    /** @var RelationshipCollectionToPhpArrayEncoderInterface */
    private $relationshipCollectionToPhpArrayEncoder;

    /** @var LinkToPhpArrayEncoderInterface */
    private $linkToPhpArrayEncoder;

    /** @var AttributeCollectionToPhpArrayEncoderInterface */
    private $attributeCollectionToPhpArrayEncoder;

    public function __construct(
        MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder,
        RelationshipCollectionToPhpArrayEncoderInterface $relationshipCollectionToPhpArrayEncoder,
        LinkToPhpArrayEncoderInterface $linkToPhpArrayEncoder,
        AttributeCollectionToPhpArrayEncoderInterface $attributeCollectionToPhpArrayEncoder
    ) {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
        $this->relationshipCollectionToPhpArrayEncoder = $relationshipCollectionToPhpArrayEncoder;
        $this->linkToPhpArrayEncoder = $linkToPhpArrayEncoder;
        $this->attributeCollectionToPhpArrayEncoder = $attributeCollectionToPhpArrayEncoder;
    }

    public function encode(ResourceInterface $resource): array
    {
        $serializedResource = [
            'type' => $resource->getType(),
            'id' => $resource->getId(),
        ];

        if (null !== $resource->getAttributes()) {
            $serializedResource['attributes'] = $this->attributeCollectionToPhpArrayEncoder->encode($resource->getAttributes());
        }

        if (null !== $resource->getMeta()) {
            $serializedResource['meta'] = $this->metaToPhpArrayEncoder->encode($resource->getMeta());
        }

        if (null !== $resource->getSelfUrl()) {
            $serializedResource['links'] = [
                'self' => $this->linkToPhpArrayEncoder->encode($resource->getSelfUrl()),
            ];
        }

        if (null !== $resource->getRelationships()) {
            $serializedResource['relationships'] = $this->relationshipCollectionToPhpArrayEncoder->encode($resource->getRelationships());
        }

        return $serializedResource;
    }
}
