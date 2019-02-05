<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request;

use Undabot\JsonApi\Model\Resource\ResourceInterface;

interface UpdateResourceRequestInterface
{
    public function getResource(): ResourceInterface;
}
