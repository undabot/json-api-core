<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollectionToPhpArrayEncoder implements RelationshipCollectionToPhpArrayEncoderInterface
{
    /** @var RelationshipToPhpArrayEncoderInterface */
    private $relationshipPhpArrayEncoder;

    public function __construct(RelationshipToPhpArrayEncoderInterface $relationshipSerializer)
    {
        $this->relationshipPhpArrayEncoder = $relationshipSerializer;
    }

    public function encode(RelationshipCollectionInterface $relationshipCollection): array
    {
        $relationships = [];

        /** @var RelationshipInterface $relationship */
        foreach ($relationshipCollection as $relationship) {
            $relationships[$relationship->getName()] = $this->relationshipPhpArrayEncoder->encode($relationship);
        }

        return $relationships;
    }
}
