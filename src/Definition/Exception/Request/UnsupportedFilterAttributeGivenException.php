<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

/** @psalm-suppress UnusedClass */
class UnsupportedFilterAttributeGivenException extends RequestException
{
    /**
     * @param string[] $unsupportedFilters
     *
     */
    public function __construct(
        array $unsupportedFilters,
        ?string $message = null,
        int $code = 0,
        \Throwable $previous = null
    ) {
        if (null === $message) {
            $message = sprintf('Unsupported filters given: `%s`', implode(', ', $unsupportedFilters));
        }

        parent::__construct($message, $code, $previous);
    }
}
