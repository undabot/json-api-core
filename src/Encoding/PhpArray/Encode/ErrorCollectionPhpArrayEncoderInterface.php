<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;

interface ErrorCollectionPhpArrayEncoderInterface
{
    public function encode(ErrorCollectionInterface $errorCollection);
}
