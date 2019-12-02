<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

use Undabot\JsonApi\Util\Exception\ValidationException;

class ValidResourceLinkageAssertion
{
    /**
     * Resource linkage MUST be represented as one of the following:
     * - null for empty to-one relationships.
     * - an empty array ([]) for empty to-many relationships.
     * - a single resource identifier object for non-empty to-one relationships.
     * - an array of resource identifier objects for non-empty to-many relationships.
     *
     * @throws ValidationException
     */
    public static function assert(?array $resourceLinkage): void
    {
        if (null === $resourceLinkage) {
            return;
        }

        if (0 === \count($resourceLinkage)) {
            return;
        }

        if (false === ArrayUtil::isMap($resourceLinkage)) {
            foreach ($resourceLinkage as $linkItem) {
                ValidResourceIdentifierAssertion::assert($linkItem);
            }

            return;
        }

        ValidResourceIdentifierAssertion::assert($resourceLinkage);
    }
}
