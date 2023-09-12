<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request\Pagination;

interface CursorInterface extends PaginationInterface
{
    public function getAfter(): ?string;

    public function getBefore(): ?string;
}
