<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Attribute;

class Attributes implements \JsonSerializable
{
    public function __construct(private readonly array $data) {}

    public function getData(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): object
    {
        return (object) $this->data;
    }
}
