<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

interface RelationshipCollectionPhpArrayEncoderInterface
{
    public function encode(RelationshipCollectionInterface $relationship);
}
