<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Exception;

class ValidationException extends \Exception
{
    /** @psalm-suppress UnusedProperty */
    private ?string $propertyPath;

    /** @psalm-suppress UnusedProperty */
    private mixed $value;

    /** @var array<int,mixed> */
    /** @psalm-suppress UnusedProperty */
    private array $constraints;

    /**
     * ValidationException constructor.
     *
     * @param array<int,mixed> $constraints
     *
     * @psalm-suppress PossiblyUnusedMethod
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
