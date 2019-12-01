<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\ValidMemberNameAssertion;

class ValidMemberNameAssertionTest extends TestCase
{
    /** @var ValidMemberNameAssertion */
    private $assertion;

    protected function setUp()
    {
        $this->assertion = new ValidMemberNameAssertion();
    }

    /**
     * @dataProvider validMemberNameExamples
     */
    public function testValidateMemberName(string $memberName): void
    {
        $this->assertTrue($this->assertion->assert($memberName));
    }

    /**
     * @dataProvider invalidMemberNameExamples
     * @dataProvider reservedCharacters
     */
    public function testInValidateMemberName(string $memberName): void
    {
        $this->assertFalse($this->assertion->assert($memberName));
    }

    public function validMemberNameExamples(): array
    {
        return [
            ['1'],
            ['a'],
            ['CapitalLetterNoUnderscore'],
            ['valid_Name'],
            ['5valid_Name'],
        ];
    }

    public function invalidMemberNameExamples(): array
    {
        return [
            [''],
            [' '],
            ['.'],
            ['_'],
            ['-'],
            [',.'],
            ['_invalidName'],
            ['_invalidName_'],
            ['_invalid_Name_'],
            ['_invalid_Name9_'],
            ['-invalid_Name9'],
            ['invalid_Name9-'],
            ['-invalid_Name9-'],
        ];
    }

    /**
     * Reserved characters must not appear in member name:
     *
     * @see https://jsonapi.org/format/#document-member-names-reserved-characters
     */
    public function reservedCharacters(): array
    {
        return [
            ['+'],
            [','],
            ['.'],
            ['['],
            [']'],
            ['!'],
            ['"'],
            ['#'],
            ['$'],
            ['%'],
            ['&'],
            ['\''],
            ['('],
            [')'],
            ['*'],
            ['/'],
            [':'],
            [';'],
            ['<'],
            ['='],
            ['>'],
            ['?'],
            ['@'],
            ['\''],
            ['^'],
            ['`'],
            ['{'],
            ['|'],
            ['}'],
            ['~'],
        ];
    }
}
