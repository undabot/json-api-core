<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;

interface PhpArrayToResourceEncoderInterface
{
    /**
     * @param array<string,mixed> $resource
     *
     * @throws JsonApiEncodingException
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function decode(array $resource): ResourceInterface;
}
