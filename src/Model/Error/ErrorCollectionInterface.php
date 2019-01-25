<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Error;

use IteratorAggregate;

interface ErrorCollectionInterface extends IteratorAggregate
{
    public function getErrors(): array;
}
