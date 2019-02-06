<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Model\Document\DocumentInterface;

interface DocumentToPhpArrayEncoderInterface
{
    public function encode(DocumentInterface $document);
}
