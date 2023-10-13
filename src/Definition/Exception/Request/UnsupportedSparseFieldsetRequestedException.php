<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

class UnsupportedSparseFieldsetRequestedException extends RequestException
{
    /**
     * @param string[] $unsupportedIncludes
     */
    public function __construct(
        array $unsupportedIncludes,
        ?string $message = null,
        int $code = 0,
        \Throwable $previous = null
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
