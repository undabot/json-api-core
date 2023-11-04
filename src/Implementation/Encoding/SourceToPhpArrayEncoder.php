<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\SourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

/** @psalm-suppress UnusedClass */
class SourceToPhpArrayEncoder implements SourceToPhpArrayEncoderInterface
{
    /**
     * @return array<string,null|string>
     */
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
