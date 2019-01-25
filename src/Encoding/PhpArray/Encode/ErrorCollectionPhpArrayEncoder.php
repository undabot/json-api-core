<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Model\Error\ErrorInterface;

class ErrorCollectionPhpArrayEncoder implements ErrorCollectionPhpArrayEncoderInterface
{
    /** @var ErrorPhpArrayEncoderInterface */
    private $errorPhpArrayEncoder;

    public function __construct(ErrorPhpArrayEncoderInterface $errorPhpArrayEncoder)
    {
        $this->errorPhpArrayEncoder = $errorPhpArrayEncoder;
    }

    public function encode(ErrorCollectionInterface $errorCollection): array
    {
        $serializedErrors = [];

        /** @var ErrorInterface $error */
        foreach ($errorCollection as $error) {
            $serializedErrors[] = $this->errorPhpArrayEncoder->encode($error);
        }

        return $serializedErrors;
    }
}
