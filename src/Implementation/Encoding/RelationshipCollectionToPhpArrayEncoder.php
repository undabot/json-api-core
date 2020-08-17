<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use ArrayObject;
use Undabot\JsonApi\Definition\Encoding\RelationshipCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\RelationshipToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipInterface;

class RelationshipCollectionToPhpArrayEncoder implements RelationshipCollectionToPhpArrayEncoderInterface
{
    /** @var RelationshipToPhpArrayEncoderInterface */
    private $relationshipToPhpArrayEncoder;

    public function __construct(RelationshipToPhpArrayEncoderInterface $relationshipToPhpArrayEncoder)
    {
        $this->relationshipToPhpArrayEncoder = $relationshipToPhpArrayEncoder;
    }

    public function encode(RelationshipCollectionInterface $relationshipCollection): ArrayObject
    {
        $relationships = [];

        /** @var RelationshipInterface $relationship */
        foreach ($relationshipCollection as $relationship) {
            $relationships[$relationship->getName()] = $this->relationshipToPhpArrayEncoder->encode($relationship);
        }

        return new ArrayObject($relationships);
    }
}
