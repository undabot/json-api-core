<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Meta;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

class Meta implements MetaInterface
{
    public function __construct(private readonly array $data) {}

    public function getData(): array
    {
        return $this->data;
    }
}
