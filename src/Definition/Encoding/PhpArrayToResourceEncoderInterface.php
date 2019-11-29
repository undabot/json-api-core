<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\PhpArrayEncodingException;

interface PhpArrayToResourceEncoderInterface
{
    /**
     * @throws PhpArrayEncodingException
     */
    public function decode(array $resource): ResourceInterface;
}
