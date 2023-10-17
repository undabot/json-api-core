<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\RelationshipCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\RelationshipToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;

/** @psalm-suppress UnusedClass */
class RelationshipCollectionToPhpArrayEncoder implements RelationshipCollectionToPhpArrayEncoderInterface
{
    private RelationshipToPhpArrayEncoderInterface $relationshipToPhpArrayEncoder;

    public function __construct(RelationshipToPhpArrayEncoderInterface $relationshipToPhpArrayEncoder)
    {
        $this->relationshipToPhpArrayEncoder = $relationshipToPhpArrayEncoder;
    }

    /**
     * @return array<string,mixed>
     */
    public function encode(RelationshipCollectionInterface $relationships): array
    {
        $relationshipsArray = [];

        foreach ($relationships as $relationship) {
            $relationshipsArray[$relationship->getName()] = $this->relationshipToPhpArrayEncoder->encode($relationship);
        }

        return $relationshipsArray;
    }
}
