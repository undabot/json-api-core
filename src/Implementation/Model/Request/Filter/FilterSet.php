<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Request\Filter;

use Assert\Assertion;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int,Filter>
 */
class FilterSet implements \IteratorAggregate
{
    /** @var Filter[] */
    private $filters;

    /** @param Filter[] $filters */
    public function __construct(array $filters)
    {
        Assertion::allIsInstanceOf($filters, Filter::class);
        $this->filters = $filters;
    }

    /**
     * @param array<string,mixed> $rawFilters Key value pairs of filters
     */
    public static function fromArray(array $rawFilters): self
    {
        $filters = [];

        foreach ($rawFilters as $name => $value) {
            $filters[] = new Filter($name, $value);
        }

        return new self($filters);
    }

    /**
     * @return \ArrayIterator<int,Filter>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->filters);
    }

    public function getFilter(string $name): ?Filter
    {
        foreach ($this->filters as $filter) {
            if ($filter->getName() === $name) {
                return $filter;
            }
        }

        return null;
    }

    public function getFilterValue(string $name): mixed
    {
        $filter = $this->getFilter($name);
        if (null === $filter) {
            return null;
        }

        return $filter->getValue();
    }

    /**
     * @return string[]
     */
    public function getFilterNames(): array
    {
        return array_map(
            static function (Filter $filter) {
                return $filter->getName();
            },
            $this->filters
        );
    }
}
