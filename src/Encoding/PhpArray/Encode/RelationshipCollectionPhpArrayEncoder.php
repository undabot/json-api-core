<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollectionPhpArrayEncoder implements RelationshipCollectionPhpArrayEncoderInterface
{
    /** @var RelationshipPhpArrayEncoderInterface */
    private $relationshipPhpArrayEncoder;

    public function __construct(RelationshipPhpArrayEncoderInterface $relationshipSerializer)
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
