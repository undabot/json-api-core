<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Error;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Model\Error\Error;
use Undabot\JsonApi\Implementation\Model\Link\Link;
use Undabot\JsonApi\Implementation\Model\Link\LinkUrl;
use Undabot\JsonApi\Implementation\Model\Meta\Meta;
use Undabot\JsonApi\Implementation\Model\Source\Source;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Error\Error
 *
 * @small
 */
final class ErrorTest extends TestCase
{
    /*
     An error object MAY have the following members:

    id: a unique identifier for this particular occurrence of the problem.
    links: a links object containing the following members:
    - about: a link that leads to further details about this particular occurrence of the problem.
    status: the HTTP status code applicable to this problem, expressed as a string value.
    code: an application-specific error code, expressed as a string value.
    title: a short, human-readable summary of the problem that SHOULD NOT change from occurrence to occurrence of the problem, except for purposes of localization.
    detail: a human-readable explanation specific to this occurrence of the problem. Like title, this field’s value can be localized.
    source: an object containing references to the source of the error, optionally including any of the following members:
    - pointer: a JSON Pointer [RFC6901] to the associated entity in the request document [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute].
    - parameter: a string indicating which URI query parameter caused the error.
    meta: a meta object containing non-standard meta-information about the error.
     */

    public function testItsPossibleToConstructErrorWithIdOnly(): void
    {
        $error = new Error('e500');
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithLinksOnly(): void
    {
        $error = new Error(null, new Link('about', new LinkUrl('/error')));
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithStatusOnly(): void
    {
        $error = new Error(null, null, 'status');
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithCodeOnly(): void
    {
        $error = new Error(null, null, null, '500');
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithTitleOnly(): void
    {
        $error = new Error(null, null, null, null, 'Server error');
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithDetailOnly(): void
    {
        $error = new Error(null, null, null, null, null, 'Server error details');
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithSourceOnly(): void
    {
        $error = new Error(null, null, null, null, null, null, new Source('/foo/bar'));
        static::assertNotNull($error);

        $error2 = new Error(null, null, null, null, null, null, new Source('/data/attributes/title', 'foo'));
        static::assertNotNull($error2);
    }

    public function testItsPossibleToConstructErrorWithMetaOnly(): void
    {
        $error = new Error(null, null, null, null, null, null, null, new Meta(['foo' => 'bar']));
        static::assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithAllAttributes(): void
    {
        $error = new Error(
            'e500',
            new Link('about', new LinkUrl('/x')),
            'Status',
            'Code',
            'Title',
            'Detail',
            new Source('/data', 'foo'),
            new Meta(['foo' => 'bar'])
        );

        static::assertNotNull($error);
    }
}
