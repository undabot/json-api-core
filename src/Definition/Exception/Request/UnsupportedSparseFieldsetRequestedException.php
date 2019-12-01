<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

use Throwable;

class UnsupportedSparseFieldsetRequestedException extends RequestException
{
    public function __construct(
        array $unsupportedIncludes,
        ?string $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        if (null === $message) {
            $message = sprintf(
                'Unsupported fields query params given: `%s`',
                implode(', ', $unsupportedIncludes)
            );
        }

        parent::__construct($message, $code, $previous);
    }
}
