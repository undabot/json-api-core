<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;

interface ErrorCollectionToPhpArrayEncoderInterface
{
    public function encode(ErrorCollectionInterface $errorCollection);
}
