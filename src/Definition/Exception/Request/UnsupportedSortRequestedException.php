<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

/** @psalm-suppress UnusedClass */
class UnsupportedSortRequestedException extends RequestException
{
    /**
     * @param string[] $unsupportedSorts
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __construct(
        array $unsupportedSorts,
        ?string $message = null,
        int $code = 0,
        \Throwable $previous = null
    ) {
        if (null === $message) {
            $message = sprintf(
                'Unsupported sort query params given: `%s`',
                implode(', ', $unsupportedSorts)
            );
        }

        parent::__construct($message, $code, $previous);
    }
}
