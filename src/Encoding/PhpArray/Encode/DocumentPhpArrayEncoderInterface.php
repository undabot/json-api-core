<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Encode;

use Undabot\JsonApi\Model\Document\DocumentInterface;

interface DocumentPhpArrayEncoderInterface
{
    public function encode(DocumentInterface $document);
}
