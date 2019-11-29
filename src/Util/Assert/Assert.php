<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

use Assert\Assertion;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;

abstract class Assert extends Assertion
{
    protected static $exceptionClass = AssertException::class;

    public static function assertForEachChild(array $array, $callable): bool
    {
        foreach ($array as $item) {
            if (false === $callable($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @throws Exception\AssertException
     */
    public static function validJsonResource(array $resource): bool
    {
        $assertion = new ValidJsonResourceAssertion();

        return $assertion->assert($resource);
    }

    public static function validJsonResourceIdentifier(array $resourceIdentifier): bool
    {
        $assertion = new ValidJsonResourceIdentifierAssertion();

        return $assertion->assert($resourceIdentifier);
    }

    public static function arrayIsMap(array $array): bool
    {
        $assertion = new ArrayIsMapAssertion();

        return $assertion->assert($array);
    }

    public static function validResourceLinkage(?array $resourceLinkage)
    {
        $assertion = new ValidResourceLinkageAssertion();

        return $assertion->assert($resourceLinkage);
    }
}
