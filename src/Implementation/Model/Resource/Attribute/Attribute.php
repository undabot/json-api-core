<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Attribute;

use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeInterface;

class Attribute implements AttributeInterface
{
    /** @var string */
    private $name;

    /** @var mixed */
    private $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
