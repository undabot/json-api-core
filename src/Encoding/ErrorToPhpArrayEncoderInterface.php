<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Error\ErrorInterface;

interface ErrorToPhpArrayEncoderInterface
{
    public function encode(ErrorInterface $error);
}
