<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceLinkageAssertion;

/**
 * @internal
 * @covers \Undabot\JsonApi\Util\ValidResourceLinkageAssertion
 *
 * @small
 */
final class ValidResourceLinkageAssertionTest extends TestCase
{
    public function validResourceLinkageData(): array
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

    /**
     * @dataProvider validResourceLinkageData
     */
    public function testValidateValidResourceLinkageArray(?array $resourceLinkage): void
    {
        // no exceptions expected here
        $this->expectNotToPerformAssertions();
        ValidResourceLinkageAssertion::assert($resourceLinkage);
    }

    public function invalidResourceLinkageData(): array
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

    /**
     * @dataProvider invalidResourceLinkageData
     */
    public function testValidateInvalidResourceLinkageArray(array $resourceLinkage): void
    {
        $this->expectException(ValidationException::class);
        ValidResourceLinkageAssertion::assert($resourceLinkage);
    }

    public function testNullIsConsideredAsValidEmptyToOneRelationship(): void
    {
        $this->expectNotToPerformAssertions();
        ValidResourceLinkageAssertion::assert(null);
    }
}
