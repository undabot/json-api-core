<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Link;

use ReflectionClass;

abstract class LinkNamesEnum
{
    public const LINK_NAME_SELF = 'self';
    public const LINK_NAME_RELATED = 'related';
    public const LINK_NAME_ABOUT = 'about'; // used in errors, see https://jsonapi.org/format/#errors

    public const LINK_NAME_PAGINATION_FIRST = 'first';
    public const LINK_NAME_PAGINATION_LAST = 'last';
    public const LINK_NAME_PAGINATION_PREV = 'prev';
    public const LINK_NAME_PAGINATION_NEXT = 'next';

    public static function getValues(): array
    {
        $oClass = new ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }
}
