<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Exception;

class ValidationException extends \Exception
{
    private ?string $propertyPath;

    private mixed $value;

    /** @var array<int,mixed> */
    private array $constraints;

    /**
     * ValidationException constructor.
     *
     * @param array<int,mixed> $constraints
     */
    public function __construct(
        string $message,
        int $code = null,
        ?string $propertyPath = null,
        mixed $value = null,
        array $constraints = []
    ) {
        parent::__construct($message, $code ?? 0);

        $this->propertyPath = $propertyPath;
        $this->value = $value;
        $this->constraints = $constraints;
    }
}
