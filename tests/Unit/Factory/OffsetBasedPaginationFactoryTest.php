<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Factory\PaginationFactory;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\OffsetBasedPagination;

/**
 * @internal
 */
#[CoversClass(OffsetBasedPagination::class)]
#[Small]
final class OffsetBasedPaginationFactoryTest extends TestCase
{
    private PaginationFactory $paginationFactory;

    protected function setUp(): void
    {
        $this->paginationFactory = new PaginationFactory();
    }

    #[DataProvider('provideItCanCreateOffsetBasedPaginationFromValidParamsCases')]
    public function testItCanCreateOffsetBasedPaginationFromValidParams($params): void
    {
        $pagination = $this->paginationFactory->fromArray($params);

        self::assertInstanceOf(OffsetBasedPagination::class, $pagination);
    }

    public static function provideItCanCreateOffsetBasedPaginationFromValidParamsCases(): iterable
    {
        return [
            [
                [
                    'limit' => 10,
                    'offset' => 2,
                ],
            ],
            [
                [
                    'limit' => '10',
                    'offset' => '2',
                ],
            ],
            [
                [
                    'limit' => 10,
                    'offset' => '2',
                ],
            ],
            [
                [
                    'limit' => '10',
                    'offset' => 2,
                ],
            ],
            [
                [
                    'limit' => 10.0,
                    'offset' => 2.0,
                ],
            ],
        ];
    }

    #[DataProvider('provideItWillThrowExceptionForInvalidParamsCases')]
    public function testItWillThrowExceptionForInvalidParams(array $invalidParams): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->paginationFactory->fromArray($invalidParams);
    }

    public static function provideItWillThrowExceptionForInvalidParamsCases(): iterable
    {
        return [
            [
                [],
            ],
            [
                ['limit' => 10],
            ],
            [
                ['offset' => 2],
            ],
            [
                [
                    'limit' => '0',
                    'offset' => '0',
                ],
            ],
            [
                [
                    'limit' => 0,
                    'offset' => 0,
                ],
            ],
            [
                [
                    'limit' => null,
                    'offset' => null,
                ],
            ],
            [
                [
                    'limit' => 10.1,
                    'offset' => 2.1,
                ],
            ],
        ];
    }

    public function testGetPageNumberWillReturnCorrectNumber(): void
    {
        $params = [
            'offset' => 3,
            'limit' => 10,
        ];

        /** @var OffsetBasedPagination $pagination */
        $pagination = $this->paginationFactory->fromArray($params);

        self::assertSame(3, $pagination->getOffset());
        self::assertSame(10, $pagination->getSize());
    }
}
