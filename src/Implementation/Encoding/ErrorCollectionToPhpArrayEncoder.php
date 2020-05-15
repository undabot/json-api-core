<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\ErrorCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;

class ErrorCollectionToPhpArrayEncoder implements ErrorCollectionToPhpArrayEncoderInterface
{
    /** @var ErrorToPhpArrayEncoderInterface */
    private $errorEncoder;

    public function __construct(ErrorToPhpArrayEncoderInterface $errorEncoder)
    {
        $this->errorEncoder = $errorEncoder;
    }

    public function encode(ErrorCollectionInterface $errorCollection): array
    {
        $serializedErrors = [];

        /** @var ErrorInterface $error */
        foreach ($errorCollection as $error) {
            $serializedErrors[] = $this->errorEncoder->encode($error);
        }

        return $serializedErrors;
    }
}
