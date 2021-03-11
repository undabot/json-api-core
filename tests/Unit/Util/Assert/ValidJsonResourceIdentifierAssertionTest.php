<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Util\Assert;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceIdentifierAssertion;

/**
 * @internal
 * @covers \Undabot\JsonApi\Util\ValidResourceIdentifierAssertion
 *
 * @small
 */
final class ValidJsonResourceIdentifierAssertionTest extends TestCase
{
    public function validResourceIdentifierData()
    {
        return [
            [
                [
                    'id' => '1',
                    'type' => 'x',
                ],
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

    /**
     * @dataProvider validResourceIdentifierData
     */
    public function testValidateValidResourceIdentifierArray(array $resourceIdentifier): void
    {
        // no exceptions expected here
        $this->expectNotToPerformAssertions();
        ValidResourceIdentifierAssertion::assert($resourceIdentifier);
    }

    public function invalidResourceIdentifierData()
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
                [
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidResourceIdentifierData
     */
    public function testValidateInvalidResourceIdentifierArray(array $resourceIdentifier): void
    {
        $this->expectException(ValidationException::class);
        ValidResourceIdentifierAssertion::assert($resourceIdentifier);
    }
}
