<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request\Sort;

use InvalidArgumentException;

/**
 * The sort order for each sort field MUST be ascending unless it is prefixed with a minus (U+002D HYPHEN-MINUS, “-“),
 * in which case it MUST be descending.
 */
class Sort
{
    const SORT_ORDER_ASC = 'ASC';
    const SORT_ORDER_DESC = 'DESC';

    /** @var string */
    private $attribute;

    /** @var string */
    private $order;

    public function __construct(string $attribute, string $order)
    {
        $this->makeSureOrderIsValid($order);
        $this->attribute = $attribute;
        $this->order = $order;
    }

    private function makeSureOrderIsValid(string $order): void
    {
        if (false === in_array($order, [self::SORT_ORDER_ASC, self::SORT_ORDER_DESC])) {
            $message = sprintf('Sort value must be either ASC or DESC, %s given', $order);
            throw new InvalidArgumentException($message);
        }
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function isAsc(): bool
    {
        return self::SORT_ORDER_ASC === $this->order;
    }

    public function isDesc(): bool
    {
        return self::SORT_ORDER_DESC === $this->order;
    }
}
