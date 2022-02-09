<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Meta;

interface MetaInterface
{
    /** @return array<int|string,mixed> */
    public function getData(): array;
}
