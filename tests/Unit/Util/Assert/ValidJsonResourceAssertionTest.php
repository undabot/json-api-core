<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceAssertion;

/**
 * @internal
 * @covers \Undabot\JsonApi\Util\ValidResourceAssertion
 *
 * @small
 */
final class ValidJsonResourceAssertionTest extends TestCase
{
    /**
     * @dataProvider validResourceData
     */
    public function testValidateValidResourceArray(array $resource): void
    {
        // no exceptions expected here
        $this->expectNotToPerformAssertions();
        ValidResourceAssertion::assert($resource);
    }

    /**
     * @dataProvider invalidResourceData
     */
    public function testValidateInvalidResourceArray(array $resource): void
    {
        $this->expectException(ValidationException::class);
        ValidResourceAssertion::assert($resource);
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

    public function testValidationFailsForNullType(): void
    {
        $this->expectException(ValidationException::class);
        $resource = [
            'type' => null,
        ];

        ValidResourceAssertion::assert($resource);
    }

    public function testValidationFailsForNullId(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Resource `id` must be string');
        $resource = [
            'type' => 'x',
            'id' => null,
        ];

        ValidResourceAssertion::assert($resource);
    }

    public function testValidationFailsForMissingType(): void
    {
        $this->expectException(ValidationException::class);
        $resource = [
            'id' => '1',
        ];

        ValidResourceAssertion::assert($resource);
    }

    public function testValidationFailsForUnsupportedKey(): void
    {
        $this->expectException(ValidationException::class);
        $resource = [
            'something' => '1',
        ];

        ValidResourceAssertion::assert($resource);
    }

    public function testValidationFailsForNonStringId(): void
    {
        $resource = [
            'id' => 1,
        ];

        $this->expectException(ValidationException::class);
        ValidResourceAssertion::assert($resource);
    }

    public function testValidationFailsForNonStringType(): void
    {
        $resource = [
            'type' => 1,
        ];

        $this->expectException(ValidationException::class);
        ValidResourceAssertion::assert($resource);
    }
}
