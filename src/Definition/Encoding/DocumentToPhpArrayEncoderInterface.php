<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Document\DocumentInterface;

interface DocumentToPhpArrayEncoderInterface
{
    /**
     * @return array<string,mixed>
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function encode(DocumentInterface $document): array;
}
