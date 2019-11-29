<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request\Pagination;

interface PaginationInterface
{
    public function getSize(): int;

    public function getOffset(): int;
}
