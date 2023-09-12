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

    public function invalidPaginationParamsProvider(): array
    {
        return [
            [
                [],
            ],
            [
                ['number' => 2],
            ],
            [
                ['offset' => 2],
            ],
            [
                [
                    'after' => null,
                    'before' => null,
                ],
            ],
            [
                [
                    'size' => 10.1,
                    'after' => 'aaa',
                ],
            ],
        ];
    }

    public function validCursorBasedPaginationParamsProvider(): array
    {
        return [
            [
                [
                    'before' => 'aaa',
                    'size' => 2,
                ],
            ],
            [
                [
                    'after' => 'aaa',
                    'size' => 2,
                ],
            ],
            [
                [
                    'before' => 'aaa',
                    'size' => '2',
                ],
            ],
            [
                [
                    'after' => 'aaa',
                    'size' => '2',
                ],
            ],
            [
                [
                    'after' => 'aaa',
                    'size' => 2.0,
                ],
            ],
            [
                [
                    'after' => 'aaa',
                ],
            ],
            [
                [
                    'before' => 'aaa',
                ],
            ],
            [
                [
                    'after' => 'aaa',
                    'before' => 'aaa',
                ],
            ],
            [
                [
                    'after' => 'aaa',
                    'before' => 'bbb',
                ],
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
