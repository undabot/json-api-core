<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request\Pagination;

class PageBasedPagination implements PaginationInterface
{
    const PARAM_PAGE_NUMBER = 'number';
    const PARAM_PAGE_SIZE = 'size';

    /** @var int */
    private $pageNumber;

    /** @var int */
    private $size;

    public function __construct(int $pageNumber, int $size)
    {
        $this->pageNumber = $pageNumber;
        $this->size = $size;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getOffset(): int
    {
        return ($this->getPageNumber() - 1) * $this->getSize();
    }
}
