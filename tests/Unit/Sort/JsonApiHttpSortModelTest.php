<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Sort;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Model\Request\Sort\Sort;
use Undabot\JsonApi\Implementation\Model\Request\Sort\SortSet;

class JsonApiHttpSortModelTest extends TestCase
{
    public function testSingleAttributeSortSetIsCreatedFromString()
    {
        $sortDefinition = 'name';
        $sortSet = SortSet::make($sortDefinition);

        $this->assertInstanceOf(SortSet::class, $sortSet);

        /** @var Sort $sort */
        $sort = iterator_to_array($sortSet)[0];
        $this->assertInstanceOf(Sort::class, $sort);
        $this->assertSame('name', $sort->getAttribute());
        $this->assertTrue($sort->isAsc());
        $this->assertFalse($sort->isDesc());
    }

    public function testSingleAttributeDescSortSetIsCreatedFromString()
    {
        $sortDefinition = '-lastName';
        $sortSet = SortSet::make($sortDefinition);

        $this->assertInstanceOf(SortSet::class, $sortSet);

        /** @var Sort $sort */
        $sort = iterator_to_array($sortSet)[0];
        $this->assertInstanceOf(Sort::class, $sort);
        $this->assertSame('lastName', $sort->getAttribute());
        $this->assertFalse($sort->isAsc());
        $this->assertTrue($sort->isDesc());
    }

    public function testMultipleAttributeSortSetIsCreatedFromString()
    {
        $sortDefinition = 'name,-lastName,author.score,-comment.createdAt';
        $sortSet = SortSet::make($sortDefinition);

        $this->assertInstanceOf(SortSet::class, $sortSet);
        $sortSetArray = iterator_to_array($sortSet);
        $this->assertCount(4, $sortSetArray);

        foreach ($sortSet as $sort) {
            $this->assertInstanceOf(Sort::class, $sort);
        }

        $this->assertSame('name', $sortSetArray[0]->getAttribute());
        $this->assertTrue($sortSetArray[0]->isAsc());
        $this->assertFalse($sortSetArray[0]->isDesc());

        $this->assertSame('lastName', $sortSetArray[1]->getAttribute());
        $this->assertFalse($sortSetArray[1]->isAsc());
        $this->assertTrue($sortSetArray[1]->isDesc());

        $this->assertSame('author.score', $sortSetArray[2]->getAttribute());
        $this->assertTrue($sortSetArray[2]->isAsc());
        $this->assertFalse($sortSetArray[2]->isDesc());

        $this->assertSame('comment.createdAt', $sortSetArray[3]->getAttribute());
        $this->assertFalse($sortSetArray[3]->isAsc());
        $this->assertTrue($sortSetArray[3]->isDesc());
    }
}
