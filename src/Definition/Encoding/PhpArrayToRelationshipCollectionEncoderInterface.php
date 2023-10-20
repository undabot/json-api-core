<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;

/** @psalm-suppress PossiblyUnusedMethod */
interface PhpArrayToRelationshipCollectionEncoderInterface
{
    /**
     * @param array<string,array<string,mixed>> $relationships
     *
     * @throws JsonApiEncodingException
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function encode(array $relationships): RelationshipCollectionInterface;
}
