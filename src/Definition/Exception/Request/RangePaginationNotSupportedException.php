<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Exception\Request;

use Throwable;

class RangePaginationNotSupportedException extends RequestException
{
    public function __construct(
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            'Range pagination not supported',
            $code,
            $previous,
        );
    }
}
