<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;
use Undabot\JsonApi\Util\Assert\ValidJsonResourceAssertion;

class ValidJsonResourceAssertionTest extends TestCase
{
    /** @var ValidJsonResourceAssertion */
    private $assertion;

    protected function setUp()
    {
        $this->assertion = new ValidJsonResourceAssertion();
    }

    /**
     * @dataProvider validResourceData
     */
    public function testValidateValidResourceArray(array $resource)
    {
        $this->assertTrue($this->assertion->assert($resource));
    }

    /**
     * @dataProvider invalidResourceData
     */
    public function testValidateInvalidResourceArray(array $resource)
    {
        $this->expectException(AssertException::class);
        $this->assertFalse($this->assertion->assert($resource));
    }

    public function validResourceData()
    {
        return [
            [
                [
                    'id' => '1',
                    'type' => 'x',
                ],
            ],
            [
                [
                    'id' => '1',
                    'type' => 'x',
                    'attributes' => [],
                    'relationships' => [],
                ],
            ],
            [
                [
                    'id' => '1',
                    'type' => 'x',
                    'meta' => [],
                    'links' => [],
                ],
            ],
            [
                [
                    'id' => '1',
                    'type' => 'x',
                    'attributes' => [],
                    'relationships' => [],
                    'meta' => [],
                    'links' => [],
                ],
            ],
        ];
    }

    public function invalidResourceData()
    {
        return [
            [
                [
                    'id' => '1',
                ],
            ],
            [
                [
                    'id' => '1',
                    'typex' => 'x',
                    'attributes' => [],
                    'relationships' => [],
                ],
            ],
            [
                [
                    'idx' => '1',
                    'type' => 'x',
                    'meta' => [],
                    'links' => [],
                ],
            ],
            [
                [
                    'id' => '1',
                    'type' => 'x',
                    'attributes' => [],
                    'relationships' => [],
                    'meta' => [],
                    'links' => [],
                    'extra' => [],
                ],
            ],
        ];
    }
}
