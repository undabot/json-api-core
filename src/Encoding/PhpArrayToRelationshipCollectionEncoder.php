<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Encoding\Exception\PhpArrayEncodingException;
use Undabot\JsonApi\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Model\Resource\Relationship\Relationship;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollection;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollection;
use Undabot\JsonApi\Util\Assert\Assert;

class PhpArrayToRelationshipCollectionEncoder implements PhpArrayToRelationshipCollectionEncoderInterface
{
    /** @var PhpArrayToMetaEncoderInterface */
    private $phpArrayToMetaEncoder;

    /** @var PhpArrayToLinkCollectionEncoderInterface */
    private $phpArrayToLinkCollectionEncoder;

    public function __construct(PhpArrayToMetaEncoderInterface $phpArrayToMetaEncoder, PhpArrayToLinkCollectionEncoderInterface $phpArrayToLinkCollectionEncoder)
    {
        $this->phpArrayToMetaEncoder = $phpArrayToMetaEncoder;
        $this->phpArrayToLinkCollectionEncoder = $phpArrayToLinkCollectionEncoder;
    }

    public function decode(array $relationships): RelationshipCollectionInterface
    {
        $decodedRelationships = [];
        foreach ($relationships as $relationshipName => $relationshipValue) {
            $decodedRelationships[] = $this->decodeRelationship($relationshipName, $relationshipValue);
        }

        return new RelationshipCollection($decodedRelationships);
    }

    private function decodeRelationship(string $relationshipName, array $relationshipValue): Relationship
    {
        $relationshipData = null;
        if (true === array_key_exists('data', $relationshipValue)) {
            $relationshipData = $this->parseRelationshipData($relationshipValue['data']);
        }

        $relationshipLinks = null;
        if (true === array_key_exists('links', $relationshipValue)) {
            $relationshipLinks = $this->phpArrayToLinkCollectionEncoder->decode($relationshipValue['links']);
        }

        $relationshipMeta = null;
        if (true === array_key_exists('meta', $relationshipValue)) {
            $relationshipMeta = $this->phpArrayToMetaEncoder->decode($relationshipValue['meta']);
        }

        return new Relationship(
            $relationshipName,
            $relationshipLinks,
            $relationshipData,
            $relationshipMeta
        );
    }

    private function parseRelationshipData(?array $resourceLinkage): ?RelationshipDataInterface
    {
        if (false === Assert::validResourceLinkage($resourceLinkage)) {
            $message = sprintf(
                'Invalid resource linkage given: %s',
                json_encode($resourceLinkage)
            );
            throw new PhpArrayEncodingException($message);
        }

        if (empty($resourceLinkage)) {
            return ToOneRelationshipData::makeEmpty();
        }

        if (true === is_array($resourceLinkage) && 0 === count($resourceLinkage)) {
            return ToManyRelationshipData::makeEmpty();
        }

        $isAssociativeArray = Assert::arrayIsMap($resourceLinkage);
        if (false === $isAssociativeArray) {
            $identifiersCollection = $this->parseResourceIdentifierCollection($resourceLinkage);

            return ToManyRelationshipData::make($identifiersCollection);
        }

        $resourceIdentifier = new ResourceIdentifier(
            $resourceLinkage['id'],
            $resourceLinkage['type'],
            $resourceLinkage['meta'] ?? null
        );

        return ToOneRelationshipData::make($resourceIdentifier);
    }

    private function parseResourceIdentifierCollection(array $data): ResourceIdentifierCollection
    {
        $resourceIdentifiers = [];

        foreach ($data as $datum) {
            Assert::validJsonResourceIdentifier($datum);
            $resourceIdentifiers[] = new ResourceIdentifier(
                $datum['id'],
                $datum['type'],
                $datum['meta'] ?? null
            );
        }

        return new ResourceIdentifierCollection($resourceIdentifiers);
    }
}
