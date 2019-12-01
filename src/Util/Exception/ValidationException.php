<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Exception;

use Exception;

class ValidationException extends Exception
{
    /**
     * @var string|null
     */
    private $propertyPath;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private $constraints;

    public function __construct(
        $message,
        $code = null,
        string $propertyPath = null,
        $value = null,
        array $constraints = []
    ) {
        parent::__construct($message, $code);

        $this->propertyPath = $propertyPath;
        $this->value = $value;
        $this->constraints = $constraints;
    }
}
