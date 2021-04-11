<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Meta;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;

class Meta implements MetaInterface
{
    /** @var array<string,mixed> */
    private $data = [];

    /** @param array<string,mixed> $data */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /** @return array<string,mixed> */
    public function getData(): array
    {
        return $this->data;
    }
}
