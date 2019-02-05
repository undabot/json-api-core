<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use DomainException;
use Undabot\JsonApi\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToManyRelationshipDataInterface;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToOneRelationshipDataInterface;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipInterface;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;

class RelationshipToPhpArrayEncoder implements RelationshipToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaPhpArrayEncoder;

    /** @var LinkCollectionToPhpArrayEncoderInterface */
    private $linkCollectionPhpArrayEncoder;

    /** @var ResourceIdentifierToPhpArrayEncoder */
    private $resourceIdentifierPhpArrayEncoder;

    public function __construct(
        MetaToPhpArrayEncoderInterface $metaPhpArrayEncoder,
        LinkCollectionToPhpArrayEncoderInterface $linkCollectionPhpArrayEncoder,
        ResourceIdentifierToPhpArrayEncoder $resourceIdentifierPhpArrayEncoder
    ) {
        $this->metaPhpArrayEncoder = $metaPhpArrayEncoder;
        $this->linkCollectionPhpArrayEncoder = $linkCollectionPhpArrayEncoder;
        $this->resourceIdentifierPhpArrayEncoder = $resourceIdentifierPhpArrayEncoder;
    }

    public function encode(RelationshipInterface $relationship): array
    {
        $serializedRelationship = [];

        if (null !== $relationship->getMeta()) {
            $serializedRelationship['meta'] = $this->metaPhpArrayEncoder->encode($relationship->getMeta());
        }

        if (null !== $relationship->getLinks()) {
            $serializedRelationship['links'] = $this->linkCollectionPhpArrayEncoder->encode($relationship->getLinks());
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

        throw new DomainException('Invalid relationship data');
    }

    private function encodeToOneRelationshipData(ToOneRelationshipDataInterface $data)
    {
        if (null === $data->getData()) {
            return null;
        }

        return $this->resourceIdentifierPhpArrayEncoder->encode($data->getData());
    }

    private function encodeToManyRelationshipData(ToManyRelationshipDataInterface $data)
    {
        if ($data->isEmpty()) {
            return [];
        }

        $serializedData = [];

        /** @var ResourceIdentifierInterface $resourceIdentifier */
        foreach ($data->getData() as $resourceIdentifier) {
            $serializedData[] = $this->resourceIdentifierPhpArrayEncoder->encode($resourceIdentifier);
        }

        return $serializedData;
    }
}
