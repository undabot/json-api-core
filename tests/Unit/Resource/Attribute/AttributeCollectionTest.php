<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Resource\Attribute;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\Attribute;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\AttributeCollection;

class AttributeCollectionTest extends TestCase
{
    public function testItCanBeConstructedWithEmptyArray()
    {
        $attributes = [];

        $attributeCollection = new AttributeCollection($attributes);

        $this->assertInstanceOf(AttributeCollectionInterface::class, $attributeCollection);
    }

    public function testItCanBeConstructedWithArrayOfAttributes()
    {
        $attributes = array_fill(0, 5, $this->createMock(Attribute::class));

        $attributeCollection = new AttributeCollection($attributes);

        $this->assertInstanceOf(AttributeCollectionInterface::class, $attributeCollection);
    }

    public function testItWillThrowExceptionIfOneAttributeIsNotInstanceOfAttribute()
    {
        $attributes = array_fill(0, 5, $this->createMock(Attribute::class));
        $attributes[] = new \stdClass();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute expected, stdClass given');

        new AttributeCollection($attributes);
    }

    public function testItWillThrowExceptionIfMultipleAttributesAreNotInstanceOfAttribute()
    {
        $validAttributes = array_fill(0, 5, $this->createMock(Attribute::class));
        $invalidAttributes = array_fill(0, 3, new \stdClass());

        $attributes = array_merge($validAttributes, $invalidAttributes);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute expected, stdClass given');

        new AttributeCollection($attributes);
    }

    public function testGetIteratorWillReturnInstanceOfArrayIterator()
    {
        $attributes = array_fill(0, 5, $this->createMock(Attribute::class));

        $attributeCollection = new AttributeCollection($attributes);

        $this->assertInstanceOf(\ArrayIterator::class, $attributeCollection->getIterator());
    }
}
