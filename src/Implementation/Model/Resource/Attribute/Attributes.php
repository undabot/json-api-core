<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Attribute;

use JsonSerializable;

class Attributes implements JsonSerializable
{
    private array $data;


    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): object
    {
        return (object) $this->data;
    }
}
