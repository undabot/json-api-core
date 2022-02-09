<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Encoding;

use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;

interface DocumentDataToPhpArrayEncoderInterface
{
    /** @return null|array<mixed,mixed> */
    public function encode(DocumentDataInterface $documentData): ?array;
}
