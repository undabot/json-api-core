<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Request\Sort;

use ArrayIterator;
use Assert\Assertion;
use IteratorAggregate;

class SortSet implements IteratorAggregate
{
    /** @var Sort[] */
    private $sorts;

    public function __construct(array $sorts)
    {
        Assertion::allIsInstanceOf($sorts, Sort::class);
        $this->sorts = $sorts;
    }

    public static function make(string $sortDefinition): self
    {
        $sorts = [];
        $sortElements = explode(',', $sortDefinition);

        foreach ($sortElements as $sortElement) {
            $order = Sort::SORT_ORDER_ASC;

            if ('-' === mb_substr($sortElement, 0, 1)) {
                $sortElement = mb_substr($sortElement, 1);
                $order = Sort::SORT_ORDER_DESC;
            }

            $sorts[] = new Sort($sortElement, $order);
        }

        return new self($sorts);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->sorts);
    }

    public function getSortsArray(): array
    {
        $sortSet = [];

        foreach ($this->sorts as $sort) {
            $direction = null;
            if (true === $sort->isAsc()) {
                $direction = Sort::SORT_ORDER_ASC;
            }

            if (true === $sort->isDesc()) {
                $direction = Sort::SORT_ORDER_DESC;
            }

            $sortSet[$sort->getAttribute()] = $direction;
        }

        return $sortSet;
    }
}
