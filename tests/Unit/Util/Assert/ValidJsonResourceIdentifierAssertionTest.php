<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;
use Undabot\JsonApi\Util\Assert\ValidJsonResourceIdentifierAssertion;

class ValidJsonResourceIdentifierAssertionTest extends TestCase
{
    /** @var ValidJsonResourceIdentifierAssertion */
    private $assertion;

    protected function setUp()
    {
        $this->assertion = new ValidJsonResourceIdentifierAssertion();
    }

    public function validResourceIdentifierData()
    {
        return [
            [
                [
                    'id' => '1',
                    'type' => 'x',
                ],
                [
                    'id' => '1',
                    'type' => 'x',
                    'meta' => [
                        'foo' => 'bar',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider validResourceIdentifierData
     */
    public function testValidateValidResourceIdentifierArray(array $resourceIdentifier)
    {
        $this->assertTrue($this->assertion->assert($resourceIdentifier));
    }

    public function invalidResourceIdentifierData()
    {
        return [
            [
                [
                    'type' => 'x',
                ],
            ],
            [
                [
                    'id' => '1',
                ],
            ],
            [
                [
                    'id' => '1',
                    'typex' => 'x',
                    'meta' => [
                        'foo' => 'bar',
                    ],
                ],
            ],
            [
                [
                    'id' => '1',
                    'type' => 'x',
                    'meta' => [],
                    'links' => [], // extra links key
                ],
            ],
            [
                [
                    'id' => 1,
                    'type' => 'x',
                    'meta' => [],
                ],
            ],
            [
                [
                    'id' => '1',
                    'type' => 1,
                    'meta' => [],
                ],
            ],
            [
                [
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidResourceIdentifierData
     */
    public function testValidateInvalidResourceIdentifierArray(array $resourceIdentifier)
    {
        $this->expectException(AssertException::class);
        $this->assertFalse($this->assertion->assert($resourceIdentifier));
    }
}
