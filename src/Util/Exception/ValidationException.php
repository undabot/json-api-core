<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Exception;

use Exception;

class ValidationException extends Exception
{
    private ?string $propertyPath;

    /**
     * @var mixed
     */
    private $value;

    private array $constraints;

    /**
     * ValidationException constructor.
     *
     * @param mixed $value
     */
    public function __construct(
        string $message,
        int $code = null,
        ?string $propertyPath = null,
        $value = null,
        array $constraints = []
    ) {
        parent::__construct($message, $code);

        $this->propertyPath = $propertyPath;
        $this->value = $value;
        $this->constraints = $constraints;
    }
}
