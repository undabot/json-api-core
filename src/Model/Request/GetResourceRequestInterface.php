<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request;

interface GetResourceRequestInterface
{
    public function getInclude(): ?array;

    public function getSparseFieldset(): ?array;
}
