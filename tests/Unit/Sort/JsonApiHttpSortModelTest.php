<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Sort;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Model\Request\Sort\Sort;
use Undabot\JsonApi\Implementation\Model\Request\Sort\SortSet;

/**
 * @internal
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

        static::assertInstanceOf(SortSet::class, $sortSet);

        /** @var Sort $sort */
        $sort = iterator_to_array($sortSet)[0];
        static::assertInstanceOf(Sort::class, $sort);
        static::assertSame('name', $sort->getAttribute());
        static::assertTrue($sort->isAsc());
        static::assertFalse($sort->isDesc());
    }

    public function testSingleAttributeDescSortSetIsCreatedFromString(): void
    {
        $sortDefinition = '-lastName';
        $sortSet = SortSet::make($sortDefinition);

        static::assertInstanceOf(SortSet::class, $sortSet);

        /** @var Sort $sort */
        $sort = iterator_to_array($sortSet)[0];
        static::assertInstanceOf(Sort::class, $sort);
        static::assertSame('lastName', $sort->getAttribute());
        static::assertFalse($sort->isAsc());
        static::assertTrue($sort->isDesc());
    }

    public function testMultipleAttributeSortSetIsCreatedFromString(): void
    {
        $sortDefinition = 'name,-lastName,author.score,-comment.createdAt';
        $sortSet = SortSet::make($sortDefinition);

        static::assertInstanceOf(SortSet::class, $sortSet);
        $sortSetArray = iterator_to_array($sortSet);
        static::assertCount(4, $sortSetArray);

        foreach ($sortSet as $sort) {
            static::assertInstanceOf(Sort::class, $sort);
        }

        static::assertSame('name', $sortSetArray[0]->getAttribute());
        static::assertTrue($sortSetArray[0]->isAsc());
        static::assertFalse($sortSetArray[0]->isDesc());

        static::assertSame('lastName', $sortSetArray[1]->getAttribute());
        static::assertFalse($sortSetArray[1]->isAsc());
        static::assertTrue($sortSetArray[1]->isDesc());

        static::assertSame('author.score', $sortSetArray[2]->getAttribute());
        static::assertTrue($sortSetArray[2]->isAsc());
        static::assertFalse($sortSetArray[2]->isDesc());

        static::assertSame('comment.createdAt', $sortSetArray[3]->getAttribute());
        static::assertFalse($sortSetArray[3]->isAsc());
        static::assertTrue($sortSetArray[3]->isDesc());
    }
}
