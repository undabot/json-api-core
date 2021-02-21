<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;

interface ErrorToPhpArrayEncoderInterface
{
    public function encode(ErrorInterface $error): array;
}
