<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request\Sort;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;

class SortSet implements IteratorAggregate
{
    /** @var Sort[] */
    private $sorts;

    /**
     * @param string $sortDefinition
     */
    public static function make(string $sortDefinition): self
    {
        $sorts = [];
        $sortElements = explode(',', $sortDefinition);

        foreach ($sortElements as $sortElement) {
            $order = Sort::SORT_ORDER_ASC;

            if ('-' === substr($sortElement, 0, 1)) {
                $sortElement = substr($sortElement, 1);
                $order = Sort::SORT_ORDER_DESC;
            }

            $sorts[] = new Sort($sortElement, $order);
        }

        return new self($sorts);
    }

    public function __construct(array $sorts)
    {
        $this->makeSureAllArrayElementsAreSorts($sorts);
        $this->sorts = $sorts;
    }

    private function makeSureAllArrayElementsAreSorts(array $sorts)
    {
        foreach ($sorts as $sort) {
            if (false === ($sort instanceof Sort)) {
                $message = sprintf('Sort expected, %s given', get_class($sort));
                throw new InvalidArgumentException($message);
            }
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->sorts);
    }
}
