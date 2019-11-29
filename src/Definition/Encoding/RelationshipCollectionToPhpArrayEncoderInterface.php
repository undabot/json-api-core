<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;

interface RelationshipCollectionToPhpArrayEncoderInterface
{
    public function encode(RelationshipCollectionInterface $relationship);
}
