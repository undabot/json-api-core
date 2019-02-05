<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

interface PhpArrayToRelationshipCollectionEncoderInterface
{
    public function decode(array $relationships): RelationshipCollectionInterface;
}
