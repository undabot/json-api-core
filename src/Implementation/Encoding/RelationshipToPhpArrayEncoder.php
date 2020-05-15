<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use DomainException;
use Undabot\JsonApi\Definition\Encoding\LinkCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\RelationshipToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToManyRelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToOneRelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

class RelationshipToPhpArrayEncoder implements RelationshipToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaToPhpArrayEncoder;

    /** @var LinkCollectionToPhpArrayEncoderInterface */
    private $linkCollectionToPhpArrayEncoder;

    /** @var ResourceIdentifierToPhpArrayEncoder */
    private $resourceIdentifierToPhpArrayEncoder;

    public function __construct(
        MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder,
        LinkCollectionToPhpArrayEncoderInterface $linkCollectionToPhpArrayEncoder,
        ResourceIdentifierToPhpArrayEncoder $resourceIdentifierToPhpArrayEncoder
    ) {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
        $this->linkCollectionToPhpArrayEncoder = $linkCollectionToPhpArrayEncoder;
        $this->resourceIdentifierToPhpArrayEncoder = $resourceIdentifierToPhpArrayEncoder;
    }

    public function encode(RelationshipInterface $relationship): array
    {
        $serializedRelationship = [];

        if (null !== $relationship->getMeta()) {
            $serializedRelationship['meta'] = $this->metaToPhpArrayEncoder->encode($relationship->getMeta());
        }

        if (null !== $relationship->getLinks()) {
            $serializedRelationship['links'] = $this->linkCollectionToPhpArrayEncoder->encode($relationship->getLinks());
        }

        if (null !== $relationship->getData()) {
            $serializedRelationship['data'] = $this->encodeRelationshipData($relationship->getData());
        }

        return $serializedRelationship;
    }

    private function encodeRelationshipData(?RelationshipDataInterface $data): ?array
    {
        if ($data instanceof ToOneRelationshipDataInterface) {
            return $this->encodeToOneRelationshipData($data);
        }

        if ($data instanceof ToManyRelationshipDataInterface) {
            return $this->encodeToManyRelationshipData($data);
        }

        // @todo this is not a domain exception, but rather UI...
        throw new DomainException('Invalid relationship data');
    }

    private function encodeToOneRelationshipData(ToOneRelationshipDataInterface $data)
    {
        if (null === $data->getData()) {
            return null;
        }

        return $this->resourceIdentifierToPhpArrayEncoder->encode($data->getData());
    }

    private function encodeToManyRelationshipData(ToManyRelationshipDataInterface $data)
    {
        if ($data->isEmpty()) {
            return [];
        }

        $serializedData = [];

        /** @var ResourceIdentifierInterface $resourceIdentifier */
        foreach ($data->getData() as $resourceIdentifier) {
            $serializedData[] = $this->resourceIdentifierToPhpArrayEncoder->encode($resourceIdentifier);
        }

        return $serializedData;
    }
}
