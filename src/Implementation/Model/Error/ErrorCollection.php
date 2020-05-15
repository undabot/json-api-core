<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Error;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;

final class ErrorCollection implements ErrorCollectionInterface
{
    /** @var Error[] */
    private $errors;

    public function __construct(array $errors)
    {
        $this->makeSureAllErrorsAreValid($errors);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getErrors());
    }

    private function makeSureAllErrorsAreValid(array $errors): void
    {
        foreach ($errors as $error) {
            if (false === ($error instanceof ErrorInterface)) {
                $message = sprintf('Error expected, %s given', \get_class($error));

                throw new InvalidArgumentException($message);
            }
        }
    }
}
