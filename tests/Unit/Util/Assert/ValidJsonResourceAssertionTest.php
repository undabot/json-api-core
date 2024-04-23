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

    public function validResourceData(): \Generator
    {
        yield 'Only valid id and type exists' => [
            [
                'id' => '1',
                'type' => 'x',
            ],
        ];

        yield 'Valid id and type exists with empty attributes and relationships' => [
            [
                'id' => '1',
                'type' => 'x',
                'attributes' => [],
                'relationships' => [],
            ],
        ];

        yield 'Valid id and type exists with empty meta and links' => [
            [
                'id' => '1',
                'type' => 'x',
                'meta' => [],
                'links' => [],
            ],
        ];

        yield 'Valid id and type exists with empty attributes, relationships, meta and links' => [
            [
                'id' => '1',
                'type' => 'x',
                'attributes' => [],
                'relationships' => [],
                'meta' => [],
                'links' => [],
            ],
        ];

        yield 'Only valid lid and type exists' => [
            [
                'lid' => '1',
                'type' => 'x',
            ],
        ];
    }

    public function invalidResourceData(): \Generator
    {
        yield 'Missing type' => [
            [
                'id' => '1',
            ],
        ];

        yield 'Typo in type' => [
            [
                'id' => '1',
                'typex' => 'x',
                'attributes' => [],
                'relationships' => [],
            ],
        ];

        yield 'Typo in id' => [
            [
                'idx' => '1',
                'type' => 'x',
                'meta' => [],
                'links' => [],
            ],
        ];

        yield 'Forbidden extra sent' => [
            [
                'id' => '1',
                'type' => 'x',
                'attributes' => [],
                'relationships' => [],
                'meta' => [],
                'links' => [],
                'extra' => [],
            ],
        ];

        yield 'Both lid and id sent' => [
            [
                'id' => '1',
                'lid' => '2',
                'type' => 'x',
                'meta' => [],
                'links' => [],
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
