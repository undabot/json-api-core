<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;


use Undabot\JsonApi\Model\Resource\Relationship\RelationshipInterface;

interface RelationshipToPhpArrayEncoderInterface
{
    public function encode(RelationshipInterface $relationship);
}
