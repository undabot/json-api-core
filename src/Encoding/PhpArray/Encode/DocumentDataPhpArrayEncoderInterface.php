<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Document\DocumentDataInterface;

interface DocumentDataPhpArrayEncoderInterface
{
    public function encode(DocumentDataInterface $documentData);
}
