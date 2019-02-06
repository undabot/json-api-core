<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Encoding\Exception\PhpArrayEncodingException;
use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface PhpArrayToResourceEncoderInterface
{
    /**
     * @throws PhpArrayEncodingException
     */
    public function decode(array $resource): ResourceInterface;
}
