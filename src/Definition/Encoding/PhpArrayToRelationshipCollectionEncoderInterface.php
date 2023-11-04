<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;

interface PhpArrayToRelationshipCollectionEncoderInterface
{
    /**
     * @param array<string,array<string,mixed>> $relationships
     *
     * @throws JsonApiEncodingException
     */
    public function encode(array $relationships): RelationshipCollectionInterface;
}
