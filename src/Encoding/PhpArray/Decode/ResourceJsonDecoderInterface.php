<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Encoding\PhpArray\Exception\PhpArrayDecodingException;
use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface ResourceJsonDecoderInterface
{
    /**
     * @throws PhpArrayDecodingException
     */
    public function decode(array $resource): ResourceInterface;
}
