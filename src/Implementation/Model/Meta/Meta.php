<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Meta;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

class Meta implements MetaInterface
{
    /** @param array<int|string,mixed> $data */
    public function __construct(private array $data) {}

    /** @return array<int|string,mixed> */
    public function getData(): array
    {
        return $this->data;
    }
}
