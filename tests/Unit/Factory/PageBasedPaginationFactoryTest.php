<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
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
        $this->expectException(InvalidArgumentException::class);
        $this->paginationFactory->fromArray($invalidParams);
    }

    public function invalidPaginationParamsProvider()
    {
        return [
            [
                [],
            ],
            [
                ['size' => 10],
            ],
            [
                ['number' => 2],
            ],
            [
                [
                    'size' => '0',
                    'number' => '0',
                ],
            ],
            [
                [
                    'size' => 0,
                    'number' => 0,
                ],
            ],
            [
                [
                    'size' => null,
                    'number' => null,
                ],
            ],
            [
                [
                    'size' => 10.1,
                    'number' => 2.1,
                ],
            ],
        ];
    }

    public function validPageBasedPaginationParamsProvider()
    {
        return [
            [
                [
                    'size' => 10,
                    'number' => 2,
                ],
            ],
            [
                [
                    'size' => '10',
                    'number' => '2',
                ],
            ],
            [
                [
                    'size' => 10,
                    'number' => '2',
                ],
            ],
            [
                [
                    'size' => '10',
                    'number' => 2,
                ],
            ],
            [
                [
                    'size' => 10.0,
                    'number' => 2.0,
                ],
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
