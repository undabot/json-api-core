<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Exception\Request\InvalidParameterValueException;
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
        $this->expectException(InvalidParameterValueException::class);
        $this->paginationFactory->fromArray($invalidParams);
    }

    public function invalidPaginationParamsProvider(): \Generator
    {
        yield 'No pagination' => [
            [],
        ];

        yield 'Missing offset' => [
            ['limit' => 10],
        ];

        yield 'Missing limit' => [
            ['offset' => 2],
        ];

        yield 'Limit and offset are both 0 as string' => [
            [
                'limit' => '0',
                'offset' => '0',
            ],
        ];

        yield 'Limit and offset are both 0 as integer' => [
            [
                'limit' => 0,
                'offset' => 0,
            ],
        ];

        yield 'Limit and offset are both null' => [
            [
                'limit' => null,
                'offset' => null,
            ],
        ];

        yield 'Limit and offset are both floats' => [
            [
                'limit' => 10.1,
                'offset' => 2.1,
            ],
        ];
    }

    public function validOffsetBasedPaginationParamsProvider(): \Generator
    {
        yield 'Valid params as integer' => [
            [
                'limit' => 10,
                'offset' => 2,
            ],
        ];

        yield 'Valid params as string' => [
            [
                'limit' => '10',
                'offset' => '2',
            ],
        ];

        yield 'Valid params where offset is string and limit is number' => [
            [
                'limit' => 10,
                'offset' => '2',
            ],
        ];

        yield 'Valid params where offset is number and limit is string' => [
            [
                'limit' => '10',
                'offset' => 2,
            ],
        ];

        yield 'Valid params as rounded floats' => [
            [
                'limit' => 10.0,
                'offset' => 2.0,
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
