<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Document\DocumentDataInterface;

interface DocumentDataToPhpArrayEncoderInterface
{
    public function encode(DocumentDataInterface $documentData);
}
