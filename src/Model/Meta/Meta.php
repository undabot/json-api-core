<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Meta;

class Meta implements MetaInterface
{
    /** @var array */
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
