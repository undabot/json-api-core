<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Source\SourceInterface;

class SourcePhpArrayEncoder implements SourcePhpArrayEncoderInterface
{
    public function encode(SourceInterface $source): array
    {
        $serializedSource = [];

        if (null !== $source->getPointer()) {
            $serializedSource['pointer'] = $source->getPointer();
        }

        if (null !== $source->getParameter()) {
            $serializedSource['pointer'] = $source->getParameter();
        }

        return $serializedSource;
    }
}
