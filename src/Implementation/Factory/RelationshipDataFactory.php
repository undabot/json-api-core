<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Factory;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifierCollection;

/** @psalm-suppress UnusedClass */
class RelationshipDataFactory
{
    /**
     * @param null|string|string[] $data
     *
     * @throws AssertionFailedException
     */
    public function make(
        string $type,
        bool $toMany,
        null|array|string $data
    ): ?RelationshipDataInterface {
        if (null === $data && true === $toMany) {
            return ToManyRelationshipData::makeEmpty();
        }

        if ([] === $data && true === $toMany) {
            return ToManyRelationshipData::makeEmpty();
        }

        if (null === $data && false === $toMany) {
            return ToOneRelationshipData::makeEmpty();
        }

        if (true === $toMany) {
            Assertion::isArray($data);
            Assertion::allString($data);

            $resourceIdentifiers = array_map(static function (string $id) use ($type) {
                return new ResourceIdentifier($id, $type);
            }, $data);

            return ToManyRelationshipData::make(
                new ResourceIdentifierCollection($resourceIdentifiers)
            );
        }

        Assertion::string($data);

        return ToOneRelationshipData::make(
            new ResourceIdentifier($data, $type)
        );
    }
}
