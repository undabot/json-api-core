<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Factory\PaginationFactory;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\PageBasedPagination;

/**
 * @internal
 */
#[CoversClass(PageBasedPagination::class)]
#[Small]
final class PageBasedPaginationFactoryTest extends TestCase
{
    private PaginationFactory $paginationFactory;

    protected function setUp(): void
    {
        $this->paginationFactory = new PaginationFactory();
    }

    #[DataProvider('providePaginationFactoryCanCreatePageBasedPaginationFromValidParamsCases')]
    public function testPaginationFactoryCanCreatePageBasedPaginationFromValidParams($params): void
    {
        $pagination = $this->paginationFactory->fromArray($params);

        self::assertInstanceOf(PageBasedPagination::class, $pagination);
    }

    public static function providePaginationFactoryCanCreatePageBasedPaginationFromValidParamsCases(): iterable
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

    #[DataProvider('providePaginationFactoryWillThrowExceptionForInvalidParamsCases')]
    public function testPaginationFactoryWillThrowExceptionForInvalidParams(array $invalidParams): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->paginationFactory->fromArray($invalidParams);
    }

    public static function providePaginationFactoryWillThrowExceptionForInvalidParamsCases(): iterable
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

    public function testGetPageNumberWillReturnCorrectNumber(): void
    {
        $params = [
            'number' => 3,
            'size' => 10,
        ];

        /** @var PageBasedPagination $pagination */
        $pagination = $this->paginationFactory->fromArray($params);

        self::assertSame(3, $pagination->getPageNumber());
        self::assertSame(10, $pagination->getSize());
    }
}
