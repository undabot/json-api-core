<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Request\Pagination;

use Undabot\JsonApi\Definition\Exception\Request\InvalidParameterValueException;
use Undabot\JsonApi\Definition\Model\Request\Pagination\CursorInterface;
use Undabot\JsonApi\Implementation\Model\Source\Source;

class CursorBasedPagination implements CursorInterface
{
    public const PARAM_PAGE_AFTER = 'after';
    public const PARAM_PAGE_BEFORE = 'before';
    public const PARAM_PAGE_SIZE = 'size';

    public function __construct(private ?string $after, private ?string $before, private ?int $size)
    {
        if (null === $this->after && null === $this->before && null === $this->size) {
            throw new InvalidParameterValueException(new Source(null), 'At least one of the params must be not null.');
        }
    }

    public function getSize(): int
    {
        return $this->size ?? 0;
    }

    public function getAfter(): ?string
    {
        return $this->after;
    }

    public function getBefore(): ?string
    {
        return $this->before;
    }

    public function getOffset(): int
    {
        throw new \LogicException('Cursor based pagination does not have offset');
    }
}
