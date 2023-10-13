<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Error;

use Assert\Assertion;
use Assert\AssertionFailedException;
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
        try {
            Assertion::allIsInstanceOf($errors, ErrorInterface::class);
        } catch (AssertionFailedException $exception) {
            //            $message = sprintf('ResourceIdentifierInterface expected, %s given', \get_class($resourceIdentifier));
            //
            //            throw new InvalidArgumentException($message);
        }
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
     * @return \ArrayIterator<int,ErrorInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->getErrors());
    }
}
