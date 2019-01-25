<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Error;

use ArrayIterator;
use InvalidArgumentException;

final class ErrorCollection implements ErrorCollectionInterface
{
    /** @var Error[] */
    private $errors;

    public function __construct(array $errors)
    {
        $this->makeSureAllErrorsAreValid($errors);
        $this->errors = $errors;
    }

    private function makeSureAllErrorsAreValid(array $errors): void
    {
        foreach ($errors as $error) {
            if (false === ($error instanceof ErrorInterface)) {
                $message = sprintf('Error expected, %s given', get_class($error));
                throw new InvalidArgumentException($message);
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getErrors());
    }
}
