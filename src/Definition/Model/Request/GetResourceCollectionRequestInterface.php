<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request;

use Undabot\JsonApi\Definition\Exception\Request\UnsupportedFilterAttributeGivenException;
use Undabot\JsonApi\Definition\Exception\Request\UnsupportedIncludeValuesGivenException;
use Undabot\JsonApi\Definition\Exception\Request\UnsupportedPaginationRequestedException;
use Undabot\JsonApi\Definition\Exception\Request\UnsupportedSortRequestedException;
use Undabot\JsonApi\Definition\Model\Request\Pagination\PaginationInterface;
use Undabot\JsonApi\Implementation\Model\Request\Filter\FilterSet;
use Undabot\JsonApi\Implementation\Model\Request\Sort\SortSet;

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
