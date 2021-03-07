<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Factory\PaginationFactory;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\OffsetBasedPagination;

/**
 * @internal
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

    /** @dataProvider validOffsetBasedPaginationParamsProvider */
    public function testItCanCreateOffsetBasedPaginationFromValidParams($params): void
    {
        $pagination = $this->paginationFactory->fromArray($params);

        static::assertInstanceOf(OffsetBasedPagination::class, $pagination);
    }

    /** @dataProvider invalidPaginationParamsProvider */
    public function testItWillThrowExceptionForInvalidParams(array $invalidParams): void
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

    public function validOffsetBasedPaginationParamsProvider()
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

        static::assertSame(3, $pagination->getOffset());
        static::assertSame(10, $pagination->getSize());
    }
}
