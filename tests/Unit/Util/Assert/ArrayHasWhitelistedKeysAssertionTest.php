<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Assert\ArrayHasOnlyWhitelistedKeysAssertion;

class ArrayHasWhitelistedKeysAssertionTest extends TestCase
{
    /** @var ArrayHasOnlyWhitelistedKeysAssertion */
    private $assertion;

    protected function setUp()
    {
        $this->assertion = new ArrayHasOnlyWhitelistedKeysAssertion();
    }

    public function validTestData()
    {
        return [
            [
                ['key1' => 'x'],
            ],
            [
                ['key1' => 'x', 'key2' => 'x'],
            ],
            [
                ['key1' => 'x', 'key2' => 'x', 'key3' => 'x'],
            ],
            [
                ['key1' => 'x', 'key3' => 'x'],
            ],
            [
                ['key2' => 'x', 'key3' => 'x'],
            ],
            [
                ['key2' => 'x'],
            ],
            [
                ['key3' => 'x'],
            ],
        ];
    }

    /**
     * @dataProvider validTestData
     */
    public function testValidateValidResourceArray(array $array)
    {
        $whitelistedKeys = ['key1', 'key2', 'key3'];

        $this->assertTrue($this->assertion->assert($array, $whitelistedKeys), (string) json_encode($array));
    }

    public function invalidTestData()
    {
        return [
            [
                ['key1x' => 'x'],
            ],
            [
                ['key1' => 'x', 'key2x' => 'x'],
            ],
            [
                ['key1' => 'x', 'key2' => 'x', 'key3x' => 'x'],
            ],
            [
                ['key1' => 'x', 'key2' => 'x', 'key3' => 'x', 'y' => 'x'],
            ],
            [
                ['key1x' => 'x', 'key3' => 'x'],
            ],
            [
                ['key2x' => 'x', 'key3' => 'x'],
            ],
            [
                ['key2' => 'x', 'x' => 'y'],
            ],
            [
                ['key3' => 'x', 'x' => 'y'],
            ],
        ];
    }

    /**
     * @dataProvider invalidTestData
     */
    public function testValidateInvalidResourceArray(array $array)
    {
        $whitelistedKeys = ['key1', 'key2', 'key3'];
        $this->assertFalse($this->assertion->assert($array, $whitelistedKeys));
    }
}
