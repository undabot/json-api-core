<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Model\Error\ErrorInterface;

class ErrorCollectionToPhpArrayEncoder implements ErrorCollectionToPhpArrayEncoderInterface
{
    /** @var ErrorToPhpArrayEncoderInterface */
    private $errorToPhpArrayEncoder;

    public function __construct(ErrorToPhpArrayEncoderInterface $errorToPhpArrayEncoder)
    {
        $this->errorToPhpArrayEncoder = $errorToPhpArrayEncoder;
    }

    public function encode(ErrorCollectionInterface $errorCollection): array
    {
        $serializedErrors = [];

        /** @var ErrorInterface $error */
        foreach ($errorCollection as $error) {
            $serializedErrors[] = $this->errorToPhpArrayEncoder->encode($error);
        }

        return $serializedErrors;
    }
}
