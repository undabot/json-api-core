<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Request\Pagination;

use Undabot\JsonApi\Definition\Model\Request\Pagination\PaginationInterface;

class PageBasedPagination implements PaginationInterface
{
    public const PARAM_PAGE_NUMBER = 'number';
    public const PARAM_PAGE_SIZE = 'size';

    public function __construct(private int $pageNumber, private int $size)
    {
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

    public function getAfter(): ?string
    {
        return null;
    }

    public function getBefore(): ?string
    {
        return null;
    }
}
