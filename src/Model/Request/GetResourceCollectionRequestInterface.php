<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request;

use Undabot\JsonApi\Exception\Request\UnsupportedFilterAttributeGivenException;
use Undabot\JsonApi\Exception\Request\UnsupportedIncludeValuesGivenException;
use Undabot\JsonApi\Exception\Request\UnsupportedPaginationRequestedException;
use Undabot\JsonApi\Exception\Request\UnsupportedSortRequestedException;
use Undabot\JsonApi\Model\Request\Filter\FilterSet;
use Undabot\JsonApi\Model\Request\Pagination\PaginationInterface;
use Undabot\JsonApi\Model\Request\Sort\SortSet;

interface GetResourceCollectionRequestInterface
{
    public function getIncludes(): ?array;

    public function isIncluded(string $name): bool;

    public function getSparseFieldset(): ?array;

    public function getFilterSet(): ?FilterSet;

    public function getPagination(): ?PaginationInterface;

    public function getSortSet(): ?SortSet;

    /**
     * @throws UnsupportedPaginationRequestedException
     */
    public function disablePagination(): self;

    /**
     * @throws UnsupportedFilterAttributeGivenException
     */
    public function allowFilters(array $allowedFilters): self;

    /**
     * @param string[] $allowedIncludes
     *
     * @throws UnsupportedIncludeValuesGivenException
     */
    public function allowIncluded(array $allowedIncludes): self;

    /**
     * @param string[] $allowedSorts
     *
     * @throws UnsupportedSortRequestedException
     */
    public function allowSorting(array $allowedSorts): self;
}
