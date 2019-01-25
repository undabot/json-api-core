<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Assert\ArrayHasRequiredKeysAssertion;

class ArrayHasRequiredKeysAssertionTest extends TestCase
{
    /** @var ArrayHasRequiredKeysAssertion */
    private $assertion;

    protected function setUp()
    {
        $this->assertion = new ArrayHasRequiredKeysAssertion();
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
        ];
    }

    /**
     * @dataProvider validTestData
     */
    public function testValidateValidResourceArray(array $array)
    {
        $requiredKeys = ['key1'];
        $this->assertTrue($this->assertion->assert($array, $requiredKeys), (string) json_encode($array));
    }

    public function invalidTestData()
    {
        return [
            [
                ['key1x' => 'x'],
            ],
            [
                ['key2' => 'x', 'key3x' => 'x'],
            ],
            [
                [],
            ],
        ];
    }

    /**
     * @dataProvider invalidTestData
     */
    public function testValidateInvalidResourceArray(array $array)
    {
        $requiredKeys = ['key1'];
        $this->assertFalse($this->assertion->assert($array, $requiredKeys), (string) json_encode($array));
    }
}
