<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\AttributeCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\RelationshipCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;

class ResourceToPhpArrayEncoder implements ResourceToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaEncoder;

    /** @var RelationshipCollectionToPhpArrayEncoderInterface */
    private $relationshipCollectionEncoder;

    /** @var LinkToPhpArrayEncoderInterface */
    private $linkEncoder;

    /** @var AttributeCollectionToPhpArrayEncoderInterface */
    private $attributeCollectionEncoder;

    public function __construct(
        MetaToPhpArrayEncoderInterface $metaEncoder,
        RelationshipCollectionToPhpArrayEncoderInterface $relationshipCollectionEncoder,
        LinkToPhpArrayEncoderInterface $linkEncoder,
        AttributeCollectionToPhpArrayEncoderInterface $attributeCollectionEncoder
    ) {
        $this->metaEncoder = $metaEncoder;
        $this->relationshipCollectionEncoder = $relationshipCollectionEncoder;
        $this->linkEncoder = $linkEncoder;
        $this->attributeCollectionEncoder = $attributeCollectionEncoder;
    }

    public function encode(ResourceInterface $resource): array
    {
        $serializedResource = [
            'type' => $resource->getType(),
            'id' => $resource->getId(),
        ];

        if (null !== $resource->getAttributes()) {
            $serializedResource['attributes'] = $this->attributeCollectionEncoder->encode($resource->getAttributes());
        }

        if (null !== $resource->getMeta()) {
            $serializedResource['meta'] = $this->metaEncoder->encode($resource->getMeta());
        }

        if (null !== $resource->getSelfUrl()) {
            $serializedResource['links'] = [
                'self' => $this->linkEncoder->encode($resource->getSelfUrl()),
            ];
        }

        if (null !== $resource->getRelationships()) {
            $serializedResource['relationships'] = $this->relationshipCollectionEncoder->encode($resource->getRelationships());
        }

        return $serializedResource;
    }
}
