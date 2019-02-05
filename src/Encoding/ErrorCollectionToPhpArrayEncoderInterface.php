<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;

interface ErrorCollectionToPhpArrayEncoderInterface
{
    public function encode(ErrorCollectionInterface $errorCollection);
}
