<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\ArrayUtil;

/**
 * @internal
 */
#[CoversClass(ArrayUtil::class)]
#[Small]
final class ArrayUtilTest extends TestCase
{
    public function testItCorrectlyValidatesValidArrays(): void
    {
        $requiredKeys = ['key1'];
        self::assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x'], $requiredKeys)
        );

        self::assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x', 'key2' => 'x'], $requiredKeys)
        );

        self::assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x', 'key2' => 'x', 'key3' => 'x'], $requiredKeys)
        );

        self::assertTrue(
            ArrayUtil::hasRequiredKeys(['key1' => 'x', 'key3' => 'x'], $requiredKeys)
        );
    }

    public function testItRecognizesInvalidArrays(): void
    {
        $requiredKeys = ['key1'];
        self::assertFalse(
            ArrayUtil::hasRequiredKeys(['key1x' => 'x'], $requiredKeys)
        );

        self::assertFalse(
            ArrayUtil::hasRequiredKeys(['key2' => 'x', 'key3x' => 'x'], $requiredKeys)
        );

        self::assertFalse(
            ArrayUtil::hasRequiredKeys([], $requiredKeys)
        );
    }
}
