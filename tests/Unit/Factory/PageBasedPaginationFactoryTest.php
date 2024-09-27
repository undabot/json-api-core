<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Exception\Request\InvalidParameterValueException;
use Undabot\JsonApi\Implementation\Factory\PaginationFactory;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\PageBasedPagination;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Request\Pagination\PageBasedPagination
 *
 * @small
 */
final class PageBasedPaginationFactoryTest extends TestCase
{
    private PaginationFactory $paginationFactory;

    protected function setUp(): void
    {
        $this->paginationFactory = new PaginationFactory();
    }

    /** @dataProvider validPageBasedPaginationParamsProvider */
    public function testPaginationFactoryCanCreatePageBasedPaginationFromValidParams($params): void
    {
        $pagination = $this->paginationFactory->fromArray($params);

        static::assertInstanceOf(PageBasedPagination::class, $pagination);
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

        yield 'Number provided without size' => [
            ['number' => 2],
        ];

        yield 'Number and size with value of 0 as string' => [
            [
                'size' => '0',
                'number' => '0',
            ],
        ];

        yield 'Number and size with value of 0 as integer' => [
            [
                'size' => 0,
                'number' => 0,
            ],
        ];

        yield 'Number and size with value of null' => [
            [
                'size' => null,
                'number' => null,
            ],
        ];

        yield 'Number and size as a float' => [
            [
                'size' => 10.1,
                'number' => 2.1,
            ],
        ];
    }

    public function validPageBasedPaginationParamsProvider(): \Generator
    {
        yield 'Number and size as integer' => [
            [
                'size' => 10,
                'number' => 2,
            ],
        ];

        yield 'Number and size as string' => [
            [
                'size' => '10',
                'number' => '2',
            ],
        ];

        yield 'Number as string and size as integer' => [
            [
                'size' => 10,
                'number' => '2',
            ],
        ];

        yield 'Size as string and number as integer' => [
            [
                'size' => '10',
                'number' => 2,
            ],
        ];

        yield 'Number and size as rounded float' => [
            [
                'size' => 10.0,
                'number' => 2.0,
            ],
        ];
    }

    public function testGetPageNumberWillReturnCorrectNumber(): void
    {
        $params = [
            'number' => 3,
            'size' => 10,
        ];

        /** @var PageBasedPagination $pagination */
        $pagination = $this->paginationFactory->fromArray($params);

        static::assertSame(3, $pagination->getPageNumber());
        static::assertSame(10, $pagination->getSize());
    }
}
