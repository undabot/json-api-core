<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Error;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Model\Error\Error;
use Undabot\JsonApi\Model\Link\Link;
use Undabot\JsonApi\Model\Link\LinkUrl;
use Undabot\JsonApi\Model\Meta\Meta;
use Undabot\JsonApi\Model\Source\Source;

class ErrorTest extends TestCase
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

    public function testItsPossibleToConstructErrorWithIdOnly()
    {
        $error = new Error('e500');
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithLinksOnly()
    {
        $error = new Error(null, new Link('about', new LinkUrl('/error')));
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithStatusOnly()
    {
        $error = new Error(null, null, 'status');
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithCodeOnly()
    {
        $error = new Error(null, null, null, '500');
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithTitleOnly()
    {
        $error = new Error(null, null, null, null, 'Server error');
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithDetailOnly()
    {
        $error = new Error(null, null, null, null, null, 'Server error details');
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithSourceOnly()
    {
        $error = new Error(null, null, null, null, null, null, new Source('/foo/bar'));
        $this->assertNotNull($error);

        $error2 = new Error(null, null, null, null, null, null, new Source('/data/attributes/title', 'foo'));
        $this->assertNotNull($error2);
    }

    public function testItsPossibleToConstructErrorWithMetaOnly()
    {
        $error = new Error(null, null, null, null, null, null, null, new Meta(['foo' => 'bar']));
        $this->assertNotNull($error);
    }

    public function testItsPossibleToConstructErrorWithAllAttributes()
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

        $this->assertNotNull($error);
    }
}
