<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request\Pagination;

interface PaginationInterface
{
    public function getSize(): int;

    /** @psalm-suppress PossiblyUnusedMethod */
    public function getOffset(): int;
}
