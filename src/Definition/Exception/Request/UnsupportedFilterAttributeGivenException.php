<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

use Throwable;

class UnsupportedFilterAttributeGivenException extends RequestException
{
    public function __construct(
        array $unsupportedFilters,
        ?string $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        if (null === $message) {
            $message = sprintf('Unsupported filters given: `%s`', implode(', ', $unsupportedFilters));
        }

        parent::__construct($message, $code, $previous);
    }
}
