<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Attribute;

use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeInterface;

class Attribute implements AttributeInterface
{
    /**
     * @param mixed $value
     */
    public function __construct(private readonly string $name, private $value) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
