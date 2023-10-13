<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Sort;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Model\Request\Sort\Sort;
use Undabot\JsonApi\Implementation\Model\Request\Sort\SortSet;

/**
 * @internal
 *
 * @covers \Undabot\JsonApi\Implementation\Model\Request\Sort\SortSet
 *
 * @small
 */
final class JsonApiHttpSortModelTest extends TestCase
{
    public function testSingleAttributeSortSetIsCreatedFromString(): void
    {
        $sortDefinition = 'name';
        $sortSet = SortSet::make($sortDefinition);

        self::assertInstanceOf(SortSet::class, $sortSet);

        /** @var Sort $sort */
        $sort = iterator_to_array($sortSet)[0];
        self::assertInstanceOf(Sort::class, $sort);
        self::assertSame('name', $sort->getAttribute());
        self::assertTrue($sort->isAsc());
        self::assertFalse($sort->isDesc());
    }

    public function testSingleAttributeDescSortSetIsCreatedFromString(): void
    {
        $sortDefinition = '-lastName';
        $sortSet = SortSet::make($sortDefinition);

        self::assertInstanceOf(SortSet::class, $sortSet);

        /** @var Sort $sort */
        $sort = iterator_to_array($sortSet)[0];
        self::assertInstanceOf(Sort::class, $sort);
        self::assertSame('lastName', $sort->getAttribute());
        self::assertFalse($sort->isAsc());
        self::assertTrue($sort->isDesc());
    }

    public function testMultipleAttributeSortSetIsCreatedFromString(): void
    {
        $sortDefinition = 'name,-lastName,author.score,-comment.createdAt';
        $sortSet = SortSet::make($sortDefinition);

        self::assertInstanceOf(SortSet::class, $sortSet);
        $sortSetArray = iterator_to_array($sortSet);
        self::assertCount(4, $sortSetArray);

        foreach ($sortSet as $sort) {
            self::assertInstanceOf(Sort::class, $sort);
        }

        self::assertSame('name', $sortSetArray[0]->getAttribute());
        self::assertTrue($sortSetArray[0]->isAsc());
        self::assertFalse($sortSetArray[0]->isDesc());

        self::assertSame('lastName', $sortSetArray[1]->getAttribute());
        self::assertFalse($sortSetArray[1]->isAsc());
        self::assertTrue($sortSetArray[1]->isDesc());

        self::assertSame('author.score', $sortSetArray[2]->getAttribute());
        self::assertTrue($sortSetArray[2]->isAsc());
        self::assertFalse($sortSetArray[2]->isDesc());

        self::assertSame('comment.createdAt', $sortSetArray[3]->getAttribute());
        self::assertFalse($sortSetArray[3]->isAsc());
        self::assertTrue($sortSetArray[3]->isDesc());
    }
}
