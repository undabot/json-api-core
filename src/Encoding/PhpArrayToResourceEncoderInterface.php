<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Encoding\Exception\PhpArrayDecodingException;
use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface PhpArrayToResourceEncoderInterface
{
    /**
     * @throws PhpArrayDecodingException
     */
    public function decode(array $resource): ResourceInterface;
}
