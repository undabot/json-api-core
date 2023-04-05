<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

use Undabot\JsonApi\Util\Exception\ValidationException;

/**
 * @internal
 */
final class ValidResourceAssertion
{
    /**
     * @throws ValidationException
     */
    public static function assert(array $resource): void
    {
        // `type` is only required member, `id` is not required when creating a resource without client-generated ID
        JsonApiAssertion::keyIsset($resource, 'type', 'Resource must have key `type`');

        // According to the JSON:API specification, these are the only allowed keys
        $allowedKeys = ['type', 'id', 'lid', 'links', 'meta', 'attributes', 'relationships'];

        // Assert that there are only whitelisted keys present
        $disallowedKeys = array_diff(array_keys($resource), $allowedKeys);
        JsonApiAssertion::count(
            $disallowedKeys,
            0,
            sprintf('Resource can only have keys: %s', implode(', ', $allowedKeys))
        );

        JsonApiAssertion::string($resource['type'], 'Resource `type` must be string');

        // id or lid are optional for resources sent in POST requests
        $isIdIncluded = true === \array_key_exists('id', $resource);
        $isLidIncluded = true === \array_key_exists('lid', $resource);
        if ($isIdIncluded) {
            JsonApiAssertion::string($resource['id'], 'Resource `id` must be string');
            // If id is included, lid can't be included
            if ($isLidIncluded) {
                throw new ValidationException('Resource can not have both `id` and `lid`', 0);
            }
        }
        // if there is no id and lid is included, it must be a string
        if ($isLidIncluded) {
            JsonApiAssertion::string($resource['lid'], 'Resource `lid` must be string');
        }


        // @todo validate attributes
        // @todo validate relationships
        // @todo valdiate links
        // @todo validate meta
    }
}
