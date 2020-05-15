<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Error;

use IteratorAggregate;

interface ErrorCollectionInterface extends IteratorAggregate
{
    public function getErrors(): array;
}
