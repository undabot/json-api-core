<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Exception\Request\InvalidParameterValueException;
use Undabot\JsonApi\Implementation\Factory\PaginationFactory;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\CursorBasedPagination;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Request\Pagination\CursorBasedPagination
 *
 * @small
 */
final class CursorBasedPaginationFactoryTest extends TestCase
{
    private PaginationFactory $paginationFactory;

    protected function setUp(): void
    {
        $this->paginationFactory = new PaginationFactory();
    }

    /** @dataProvider validCursorBasedPaginationParamsProvider */
    public function testPaginationFactoryCanCreateCursorBasedPaginationFromValidParams($params): void
    {
        $pagination = $this->paginationFactory->fromArray($params);

        static::assertInstanceOf(CursorBasedPagination::class, $pagination);
    }

    /** @dataProvider invalidPaginationParamsProvider */
    public function testPaginationFactoryWillThrowExceptionForInvalidParams(array $invalidParams): void
    {
        $this->expectException(InvalidParameterValueException::class);
        $this->paginationFactory->fromArray($invalidParams);
    }

    public function invalidPaginationParamsProvider(): \Generator
    {
        yield 'No pagination' => [
            [],
        ];

        yield 'Incomplete page based pagination key provided' => [
            ['number' => 2],
        ];

        yield 'Incomplete offset based pagination key provided' => [
            ['offset' => 2],
        ];

        yield 'After and before provided with no values' => [
            [
                'after' => null,
                'before' => null,
            ],
        ];

        yield 'Invalid size number format provided' => [
            [
                'size' => 10.1,
                'after' => 'aaa',
            ],
        ];
    }

    public function validCursorBasedPaginationParamsProvider(): \Generator
    {
        yield 'Valid before and size' => [
            [
                'before' => 'aaa',
                'size' => 2,
            ],
        ];

        yield 'Valid after and size' => [
            [
                'after' => 'aaa',
                'size' => 2,
            ],
        ];

        yield 'Valid before and size as string' => [
            [
                'before' => 'aaa',
                'size' => '2',
            ],
        ];

        yield 'Valid after and size as string' => [
            [
                'after' => 'aaa',
                'size' => '2',
            ],
        ];

        yield 'Valid after and size as rounded float' => [
            [
                'after' => 'aaa',
                'size' => 2.0,
            ],
        ];

        yield 'Only after' => [
            [
                'after' => 'aaa',
            ],
        ];

        yield 'Only before' => [
            [
                'before' => 'aaa',
            ],
        ];

        yield 'After and before with same values' => [
            [
                'after' => 'aaa',
                'before' => 'aaa',
            ],
        ];

        yield 'After and before with different values' => [
            [
                'after' => 'aaa',
                'before' => 'bbb',
            ],
        ];
    }

    public function testGetPageSizeWillReturnCorrectNumberGivenPageSizeIsProvided(): void
    {
        $params = [
            'before' => 'aaa',
            'size' => 10,
        ];

        /** @var CursorBasedPagination $pagination */
        $pagination = $this->paginationFactory->fromArray($params);

        static::assertSame(10, $pagination->getSize());
    }

    public function testGetPageSizeWillReturnZeroGivenPageSizeIsNotProvided(): void
    {
        $params = [
            'after' => 'aaa',
        ];

        /** @var CursorBasedPagination $pagination */
        $pagination = $this->paginationFactory->fromArray($params);

        static::assertSame(0, $pagination->getSize());
    }
}
