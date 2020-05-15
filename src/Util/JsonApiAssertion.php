<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

use Assert\Assertion as BaseAssertion;
use Undabot\JsonApi\Util\Exception\ValidationException;

/**
 * Proxy class to Beberlei Assertion with overriden exception class.
 *
 * @internal
 */
abstract class JsonApiAssertion extends BaseAssertion
{
    protected static $exceptionClass = ValidationException::class;
}
