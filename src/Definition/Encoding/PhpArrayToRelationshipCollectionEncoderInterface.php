<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;

interface PhpArrayToRelationshipCollectionEncoderInterface
{
    public function encode(array $relationships): RelationshipCollectionInterface;
}
