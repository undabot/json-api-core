<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\ArrayUtil;

class ArrayUtilTest extends TestCase
{
    public function testItCorrectlyValidatesValidArrays()
    {
        $requiredKeys = ['key1'];
        $this->assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x'], $requiredKeys)
        );

        $this->assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x', 'key2' => 'x'], $requiredKeys)
        );

        $this->assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x', 'key2' => 'x', 'key3' => 'x'], $requiredKeys)
        );

        $this->assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x', 'key3' => 'x'], $requiredKeys)
        );
    }

    public function testItRecognizesInvalidArrays()
    {
        $requiredKeys = ['key1'];
        $this->assertFalse(
            ArrayUtil::hasRequiredKeys(['key1x' => 'x'], $requiredKeys)
        );

        $this->assertFalse(
            ArrayUtil::hasRequiredKeys(['key2' => 'x', 'key3x' => 'x'], $requiredKeys)
        );

        $this->assertFalse(
            ArrayUtil::hasRequiredKeys([], $requiredKeys)
        );
    }
}
