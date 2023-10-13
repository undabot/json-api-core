<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Factory\PaginationFactory;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\OffsetBasedPagination;

/**
 * @internal
 *
 * @covers \Undabot\JsonApi\Implementation\Model\Request\Pagination\OffsetBasedPagination
 *
 * @small
 */
final class OffsetBasedPaginationFactoryTest extends TestCase
{
    private PaginationFactory $paginationFactory;

    protected function setUp(): void
    {
        $this->paginationFactory = new PaginationFactory();
    }

    /** @dataProvider provideItCanCreateOffsetBasedPaginationFromValidParamsCases */
    public function testItCanCreateOffsetBasedPaginationFromValidParams($params): void
    {
        $pagination = $this->paginationFactory->fromArray($params);

        self::assertInstanceOf(OffsetBasedPagination::class, $pagination);
    }

    /** @dataProvider provideItWillThrowExceptionForInvalidParamsCases */
    public function testItWillThrowExceptionForInvalidParams(array $invalidParams): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->paginationFactory->fromArray($invalidParams);
    }

    public function provideItWillThrowExceptionForInvalidParamsCases(): iterable
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

    public function provideItCanCreateOffsetBasedPaginationFromValidParamsCases(): iterable
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
