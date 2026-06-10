<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceIdentifierAssertion;

/**
 * @internal
 */
#[CoversClass(ValidResourceIdentifierAssertion::class)]
#[Small]
final class ValidJsonResourceIdentifierAssertionTest extends TestCase
{
    #[DataProvider('provideValidateValidResourceIdentifierArrayCases')]
    public function testValidateValidResourceIdentifierArray(array $resourceIdentifier): void
    {
        // no exceptions expected here
        $this->expectNotToPerformAssertions();
        ValidResourceIdentifierAssertion::assert($resourceIdentifier);
    }

    public static function provideValidateValidResourceIdentifierArrayCases(): iterable
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
                    'meta' => [
                        'foo' => 'bar',
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('provideValidateInvalidResourceIdentifierArrayCases')]
    public function testValidateInvalidResourceIdentifierArray(array $resourceIdentifier): void
    {
        $this->expectException(ValidationException::class);
        ValidResourceIdentifierAssertion::assert($resourceIdentifier);
    }

    public static function provideValidateInvalidResourceIdentifierArrayCases(): iterable
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
                [],
            ],
        ];
    }
}
