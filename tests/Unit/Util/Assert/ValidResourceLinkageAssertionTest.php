<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceLinkageAssertion;

/**
 * @internal
 */
#[CoversClass(ValidResourceLinkageAssertion::class)]
#[Small]
final class ValidResourceLinkageAssertionTest extends TestCase
{
    #[DataProvider('provideValidateValidResourceLinkageArrayCases')]
    public function testValidateValidResourceLinkageArray(?array $resourceLinkage): void
    {
        // no exceptions expected here
        $this->expectNotToPerformAssertions();
        ValidResourceLinkageAssertion::assert($resourceLinkage);
    }

    public static function provideValidateValidResourceLinkageArrayCases(): iterable
    {
        return [
            [
                null, // empty to one
            ],
            [
                [], // empty to many
            ],
            [
                ['id' => '1', 'type' => 'category'],
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

    #[DataProvider('provideValidateInvalidResourceLinkageArrayCases')]
    public function testValidateInvalidResourceLinkageArray(array $resourceLinkage): void
    {
        $this->expectException(ValidationException::class);
        ValidResourceLinkageAssertion::assert($resourceLinkage);
    }

    public static function provideValidateInvalidResourceLinkageArrayCases(): iterable
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

    public function testNullIsConsideredAsValidEmptyToOneRelationship(): void
    {
        $this->expectNotToPerformAssertions();
        ValidResourceLinkageAssertion::assert(null);
    }
}
