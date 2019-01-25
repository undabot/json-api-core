<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request\Filter;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;

class FilterSet implements IteratorAggregate
{
    /** @var Filter[] */
    private $filters;

    /**
     * @param array $rawFilters Key value pairs of filters
     */
    public static function createFromArray(array $rawFilters)
    {
        $filters = [];

        foreach ($rawFilters as $name => $value) {
            $filters[] = new Filter($name, $value);
        }

        return new self($filters);
    }

    public function __construct(array $filters)
    {
        $this->makeSureAllArrayElementsAreFilters($filters);
        $this->filters = $filters;
    }

    private function makeSureAllArrayElementsAreFilters(array $filters)
    {
        foreach ($filters as $filter) {
            if (false === ($filter instanceof Filter)) {
                $message = sprintf('Filter expected, %s given', get_class($filter));
                throw new InvalidArgumentException($message);
            }
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->filters);
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
}
