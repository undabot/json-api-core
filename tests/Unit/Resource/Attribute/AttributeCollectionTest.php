<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Resource\Attribute;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\Attribute;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\AttributeCollection;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Resource\Attribute\AttributeCollection
 *
 * @small
 */
final class AttributeCollectionTest extends TestCase
{
    public function testItCanBeConstructedWithEmptyArray(): void
    {
        $attributes = [];

        $attributeCollection = new AttributeCollection($attributes);

        static::assertInstanceOf(AttributeCollectionInterface::class, $attributeCollection);
    }

    public function testItCanBeConstructedWithArrayOfAttributes(): void
    {
        $attributes = array_fill(0, 5, $this->createMock(Attribute::class));

        $attributeCollection = new AttributeCollection($attributes);

        static::assertInstanceOf(AttributeCollectionInterface::class, $attributeCollection);
    }

    public function testItWillThrowExceptionIfOneAttributeIsNotInstanceOfAttribute(): void
    {
        $attributes = array_fill(0, 5, $this->createMock(Attribute::class));
        $attributes[] = new \stdClass();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute expected, stdClass given');

        new AttributeCollection($attributes);
    }

    public function testItWillThrowExceptionIfMultipleAttributesAreNotInstanceOfAttribute(): void
    {
        $validAttributes = array_fill(0, 5, $this->createMock(Attribute::class));
        $invalidAttributes = array_fill(0, 3, new \stdClass());

        $attributes = array_merge($validAttributes, $invalidAttributes);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute expected, stdClass given');

        new AttributeCollection($attributes);
    }

    public function testGetIteratorWillReturnInstanceOfArrayIterator(): void
    {
        $attributes = array_fill(0, 5, $this->createMock(Attribute::class));

        $attributeCollection = new AttributeCollection($attributes);

        static::assertInstanceOf(\ArrayIterator::class, $attributeCollection->getIterator());
    }
}
