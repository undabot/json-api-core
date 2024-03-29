<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToLinkCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToRelationshipCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToManyRelationshipDataInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\ToOneRelationshipDataInterface;
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
    public function __construct(
        private PhpArrayToMetaEncoderInterface $phpArrayToMetaEncoder,
        private PhpArrayToLinkCollectionEncoderInterface $phpArrayToLinkCollectionEncoder
    ) {
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
        $relationshipMeta = null;
        if (true === \array_key_exists('data', $relationshipValue)) {
            $relationshipData = $this->parseRelationshipData($relationshipValue['data']);
            if ($relationshipData instanceof ToOneRelationshipDataInterface) {
                $data = $relationshipValue['data'] ?? null;
                if (null !== $data && true === \array_key_exists('meta', $data)) {
                    $relationshipMeta = $this->phpArrayToMetaEncoder->decode($relationshipValue['data']['meta']);
                }
            } elseif ($relationshipData instanceof ToManyRelationshipDataInterface) {
                $relationshipMetas = [];
                foreach ($relationshipValue['data'] as $relationshipDatum) {
                    if (true === \array_key_exists('meta', $relationshipDatum)) {
                        $relationshipMetas[] = $relationshipDatum['meta'];
                    }
                }

                $relationshipMeta = $this->phpArrayToMetaEncoder->decode($relationshipMetas);
            }
        }

        $relationshipLinks = null;
        if (true === \array_key_exists('links', $relationshipValue)) {
            $relationshipLinks = $this->phpArrayToLinkCollectionEncoder->encode($relationshipValue['links']);
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
            (true === \array_key_exists('meta', $resourceLinkage)) ? $this->phpArrayToMetaEncoder->decode($resourceLinkage['meta']) : null,
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
                (true === \array_key_exists('meta', $datum)) ? $this->phpArrayToMetaEncoder->decode($datum['meta']) : null,
            );
        }

        return new ResourceIdentifierCollection($resourceIdentifiers);
    }
}
