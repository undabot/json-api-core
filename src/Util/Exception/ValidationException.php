<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Exception;

class ValidationException extends \Exception
{
    /**
     * @param mixed[] $constraints
     */
    public function __construct(
        string $message,
        int $code = 0,
        private readonly ?string $propertyPath = null,
        private readonly mixed $value = null,
        private readonly array $constraints = [],
    ) {
        parent::__construct($message, $code);
    }

    public function getPropertyPath(): ?string
    {
        return $this->propertyPath;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return mixed[]
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }
}
