<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToLinkCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToRelationshipCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Relationship;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\RelationshipCollection;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifierCollection;
use Undabot\JsonApi\Util\ArrayUtil;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceIdentifierAssertion;
use Undabot\JsonApi\Util\ValidResourceLinkageAssertion;

class PhpArrayToRelationshipCollectionEncoder implements PhpArrayToRelationshipCollectionEncoderInterface
{
    /** @var PhpArrayToMetaEncoderInterface */
    private $phpArrayToMetaEncoder;

    /** @var PhpArrayToLinkCollectionEncoderInterface */
    private $phpArrayToLinkCollectionEncoder;

    public function __construct(
        PhpArrayToMetaEncoderInterface $phpArrayToMetaEncoder,
        PhpArrayToLinkCollectionEncoderInterface $phpArrayToLinkCollectionEncoder
    ) {
        $this->phpArrayToMetaEncoder = $phpArrayToMetaEncoder;
        $this->phpArrayToLinkCollectionEncoder = $phpArrayToLinkCollectionEncoder;
    }

    /**
     * @throws JsonApiEncodingException
     */
    public function encode(array $relationships): RelationshipCollectionInterface
    {
        $decodedRelationships = [];
        foreach ($relationships as $relationshipName => $relationshipValue) {
            $decodedRelationships[] = $this->decodeRelationship(
                $relationshipName,
                $relationshipValue
            );
        }

        return new RelationshipCollection($decodedRelationships);
    }

    /**
     * @throws JsonApiEncodingException
     */
    private function decodeRelationship(string $relationshipName, array $relationshipValue): Relationship
    {
        $relationshipData = null;
        if (true === \array_key_exists('data', $relationshipValue)) {
            $relationshipData = $this->parseRelationshipData($relationshipValue['data']);
        }

        $relationshipLinks = null;
        if (true === \array_key_exists('links', $relationshipValue)) {
            $relationshipLinks = $this->phpArrayToLinkCollectionEncoder->encode($relationshipValue['links']);
        }

        $relationshipMeta = null;
        if (true === \array_key_exists('meta', $relationshipValue)) {
            $relationshipMeta = $this->phpArrayToMetaEncoder->decode($relationshipValue['meta']);
        }

        return new Relationship(
            $relationshipName,
            $relationshipLinks,
            $relationshipData,
            $relationshipMeta
        );
    }

    /**
     * @throws JsonApiEncodingException
     */
    private function parseRelationshipData(?array $resourceLinkage): RelationshipDataInterface
    {
        try {
            ValidResourceLinkageAssertion::assert($resourceLinkage);
        } catch (ValidationException $exception) {
            throw new JsonApiEncodingException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        if (null === $resourceLinkage) {
            return ToOneRelationshipData::makeEmpty();
        }

        if (true === \is_array($resourceLinkage) && 0 === \count($resourceLinkage)) {
            return ToManyRelationshipData::makeEmpty();
        }

        $isAssociativeArray = ArrayUtil::isMap($resourceLinkage);
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
            ValidResourceIdentifierAssertion::assert($datum);
            $resourceIdentifiers[] = new ResourceIdentifier(
                $datum['id'],
                $datum['type'],
                $datum['meta'] ?? null
            );
        }

        return new ResourceIdentifierCollection($resourceIdentifiers);
    }
}
