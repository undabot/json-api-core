<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request;

use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface CreateResourceRequestInterface
{
    public function getResource(): ResourceInterface;
}
