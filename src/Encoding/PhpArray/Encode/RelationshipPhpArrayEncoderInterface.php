<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Resource\Relationship\RelationshipInterface;

interface RelationshipPhpArrayEncoderInterface
{
    public function encode(RelationshipInterface $relationship);
}
