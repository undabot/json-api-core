<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollectionToPhpArrayEncoder implements RelationshipCollectionToPhpArrayEncoderInterface
{
    /** @var RelationshipToPhpArrayEncoderInterface */
    private $relationshipToPhpArrayEncoder;

    public function __construct(RelationshipToPhpArrayEncoderInterface $relationshipToPhpArrayEncoder)
    {
        $this->relationshipToPhpArrayEncoder = $relationshipToPhpArrayEncoder;
    }

    public function encode(RelationshipCollectionInterface $relationshipCollection): array
    {
        $relationships = [];

        /** @var RelationshipInterface $relationship */
        foreach ($relationshipCollection as $relationship) {
            $relationships[$relationship->getName()] = $this->relationshipToPhpArrayEncoder->encode($relationship);
        }

        return $relationships;
    }
}
