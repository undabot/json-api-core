<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request\Pagination;

class OffsetBasedPagination implements PaginationInterface
{
    const PARAM_PAGE_OFFSET = 'offset';
    const PARAM_PAGE_LIMIT = 'limit';

    /** @var int */
    private $offset;

    /** @var int */
    private $limit;

    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getSize(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
