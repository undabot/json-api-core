<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\LinkCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\RelationshipToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToManyRelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToOneRelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipInterface;

/** @psalm-suppress UnusedClass */
class RelationshipToPhpArrayEncoder implements RelationshipToPhpArrayEncoderInterface
{
    private MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder;

    private LinkCollectionToPhpArrayEncoderInterface $linkCollectionToPhpArrayEncoder;

    private ResourceIdentifierToPhpArrayEncoder $resourceIdentifierToPhpArrayEncoder;

    public function __construct(
        MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder,
        LinkCollectionToPhpArrayEncoderInterface $linkCollectionToPhpArrayEncoder,
        ResourceIdentifierToPhpArrayEncoder $resourceIdentifierToPhpArrayEncoder
    ) {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
        $this->linkCollectionToPhpArrayEncoder = $linkCollectionToPhpArrayEncoder;
        $this->resourceIdentifierToPhpArrayEncoder = $resourceIdentifierToPhpArrayEncoder;
    }

    /**
     * @return array<string,mixed>
     */
    public function encode(RelationshipInterface $relationship): array
    {
        $serializedRelationship = [];
        $meta = $relationship->getMeta();
        if (null !== $meta) {
            $serializedRelationship['meta'] = $this->metaToPhpArrayEncoder->encode($meta);
        }

        $links = $relationship->getLinks();
        if (null !== $links) {
            $serializedRelationship['links'] = $this->linkCollectionToPhpArrayEncoder->encode($links);
        }
        $data = $relationship->getData();
        if (null !== $data) {
            $serializedRelationship['data'] = $this->encodeRelationshipData($data);
        }

        return $serializedRelationship;
    }

    /**
     * @return null|array<mixed,mixed>
     */
    private function encodeRelationshipData(?RelationshipDataInterface $data): ?array
    {
        if ($data instanceof ToOneRelationshipDataInterface) {
            return $this->encodeToOneRelationshipData($data);
        }

        if ($data instanceof ToManyRelationshipDataInterface) {
            return $this->encodeToManyRelationshipData($data);
        }

        // @todo this is not a domain exception, but rather UI...
        throw new \DomainException('Invalid relationship data');
    }

    /**
     * @return null|array<string,mixed>
     */
    private function encodeToOneRelationshipData(ToOneRelationshipDataInterface $data): ?array
    {
        $data = $data->getData();
        if (null === $data) {
            return null;
        }

        return $this->resourceIdentifierToPhpArrayEncoder->encode($data);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function encodeToManyRelationshipData(ToManyRelationshipDataInterface $data): array
    {
        if ($data->isEmpty()) {
            return [];
        }

        $serializedData = [];

        foreach ($data->getData() as $resourceIdentifier) {
            $serializedData[] = $this->resourceIdentifierToPhpArrayEncoder->encode($resourceIdentifier);
        }

        return $serializedData;
    }
}
