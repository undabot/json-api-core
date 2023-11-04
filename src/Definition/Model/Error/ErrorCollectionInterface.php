<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Error;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<int,ErrorInterface>
 */
interface ErrorCollectionInterface extends \IteratorAggregate
{
    /** @return ErrorInterface[] */
    public function getErrors(): array;
}
