<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request;

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
}
