<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Factory;

use Assert\Assertion;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\Data\RelationshipDataInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifierCollection;

class RelationshipDataFactory
{
    public function make(string $type, bool $toMany, array|string|null $data): RelationshipDataInterface
    {
        if (true === $toMany) {
            if (null === $data || [] === $data) {
                return ToManyRelationshipData::makeEmpty();
            }

            Assertion::isArray($data);
            Assertion::allString($data);

            $resourceIdentifiers = array_map(static fn (string $id) => new ResourceIdentifier($id, $type), $data);

            return ToManyRelationshipData::make(
                new ResourceIdentifierCollection($resourceIdentifiers)
            );
        }

        if (null === $data) {
            return ToOneRelationshipData::makeEmpty();
        }

        Assertion::string($data);

        return ToOneRelationshipData::make(
            new ResourceIdentifier($data, $type)
        );
    }
}
