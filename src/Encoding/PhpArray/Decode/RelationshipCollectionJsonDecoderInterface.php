<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

interface RelationshipCollectionJsonDecoderInterface
{
    public function decode(array $relationships): RelationshipCollectionInterface;
}
