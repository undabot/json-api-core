<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\SourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

class SourceToPhpArrayEncoder implements SourceToPhpArrayEncoderInterface
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
