<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

use Throwable;
use Undabot\JsonApi\Implementation\Model\Source\Source;

class InvalidParameterValueException extends RequestException
{
    public function __construct(
        private Source $source,
        string $message,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function source(): Source
    {
        return $this->source;
    }
}
