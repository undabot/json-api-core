<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

use Undabot\JsonApi\Util\Assert\Exception\AssertException;

class ValidResourceLinkageAssertion
{
    /**
     * Resource linkage MUST be represented as one of the following:
     * - null for empty to-one relationships.
     * - an empty array ([]) for empty to-many relationships.
     * - a single resource identifier object for non-empty to-one relationships.
     * - an array of resource identifier objects for non-empty to-many relationships
     */
    public function assert(?array $resourceLinkage): bool
    {
        if (null === $resourceLinkage) {
            return true;
        }

        if (0 === count($resourceLinkage)) {
            return true;
        }

        if (false === Assert::arrayIsMap($resourceLinkage)) {
            return Assert::assertForEachChild($resourceLinkage, function ($item) {
                Assert::validJsonResourceIdentifier($item);
            });
        }

        if (true === Assert::arrayIsMap($resourceLinkage)) {
            return Assert::validJsonResourceIdentifier($resourceLinkage);
        }

        throw new AssertException('Not recognized resource linkage type: ' . json_encode($resourceLinkage));
    }
}
