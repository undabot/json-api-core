<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Model\Error\ErrorInterface;

class ErrorCollectionToPhpArrayEncoder implements ErrorCollectionToPhpArrayEncoderInterface
{
    /** @var ErrorToPhpArrayEncoderInterface */
    private $errorPhpArrayEncoder;

    public function __construct(ErrorToPhpArrayEncoderInterface $errorPhpArrayEncoder)
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
