<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

interface RelationshipCollectionToPhpArrayEncoderInterface
{
    public function encode(RelationshipCollectionInterface $relationship);
}
