<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Request\Pagination;

use Undabot\JsonApi\Definition\Model\Request\Pagination\PaginationInterface;

class OffsetBasedPagination implements PaginationInterface
{
    public const PARAM_PAGE_OFFSET = 'offset';
    public const PARAM_PAGE_LIMIT = 'limit';

    public function __construct(private int $offset, private int $limit)
    {
    }

    public function getSize(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getAfter(): ?string
    {
        return null;
    }

    public function getBefore(): ?string
    {
        return null;
    }
}
