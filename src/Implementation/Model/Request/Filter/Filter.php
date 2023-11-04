<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Request\Filter;

class Filter
{
    private string $name;

    /** @var mixed */
    private $value;

    /** @param mixed $value */
    public function __construct(string $name, $value)
    {
        $this->makeSureValueIsValid($value);
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /** @param mixed $value */
    private function makeSureValueIsValid($value): void
    {
        if (true === \is_object($value)) {
            throw new \InvalidArgumentException('Filter value can\'t be object');
        }

        if (null === $value) {
            throw new \InvalidArgumentException('Filter value can\'t be null');
        }

        if (true === \is_array($value)) {
            throw new \InvalidArgumentException('Filter value can\'t be array');
        }

        if (
            false === \is_string($value)
            && false === \is_float($value)
            && false === \is_int($value)
        ) {
            throw new \InvalidArgumentException('Value must be either string, integer or float');
        }
    }
}
