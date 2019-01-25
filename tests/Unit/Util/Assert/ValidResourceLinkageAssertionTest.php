<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;
use Undabot\JsonApi\Util\Assert\ValidResourceLinkageAssertion;

class ValidResourceLinkageAssertionTest extends TestCase
{
    /** @var ValidResourceLinkageAssertion */
    private $assertion;

    protected function setUp()
    {
        $this->assertion = new ValidResourceLinkageAssertion();
    }

    public function validResourceLinkageData()
    {
        return [
            [
                [
                    'id' => '1',
                    'type' => 'category',
                ],
            ],
            [
                null,
            ],
            [
                [],
            ],
            [
                [
                    ['id' => '1', 'type' => 'category'],
                    ['id' => '2', 'type' => 'category'],
                    ['id' => '3', 'type' => 'category'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider validResourceLinkageData
     */
    public function testValidateValidResourceLinkageArray(?array $resourceLinkage)
    {
        $this->assertTrue($this->assertion->assert($resourceLinkage));
    }

    public function invalidResourceLinkageData()
    {
        return [
            [
                ['idx' => '1', 'type' => 'category'],
            ],
            [
                ['id' => '1', 'typex' => 'category'],
            ],
        ];
    }

    /**
     * @dataProvider invalidResourceLinkageData
     */
    public function testValidateInvalidResourceLinkageArray(array $resourceLinkage)
    {
        $this->expectException(AssertException::class);
        $this->assertFalse($this->assertion->assert($resourceLinkage));
    }
}
