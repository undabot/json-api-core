<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

use Throwable;

class MaxPageSizeExceededException extends RequestException
{
    public function __construct(
        int $requestedPageSize,
        int $maxPageSize,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf('You requested a size of %d, but %d is the maximum.', $requestedPageSize, $maxPageSize),
            $code,
            $previous,
        );
    }
}
