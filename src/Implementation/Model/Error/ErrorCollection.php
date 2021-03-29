<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Error;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;

final class ErrorCollection implements ErrorCollectionInterface
{
    /** @var ErrorInterface[] */
    private $errors;

    /** @param ErrorInterface[] $errors */
    public function __construct(array $errors)
    {
        $this->makeSureAllErrorsAreValid($errors);
        $this->errors = $errors;
    }

    /**
     * @return ErrorInterface[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return ArrayIterator<int,ErrorInterface>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getErrors());
    }

    /** @param ErrorInterface[] $errors */
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
