<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Implementation\Factory\RelationshipDataFactory;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Factory\RelationshipDataFactory
 *
 * @small
 */
final class RelationshipDataFactoryTest extends TestCase
{
    private RelationshipDataFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new RelationshipDataFactory();
    }

    public function testFactoryCreatesEmptyToManyDataWhenNullDataGiven(): void
    {
        $data = $this->factory->make('type', true, null);
        static::assertInstanceOf(ToManyRelationshipData::class, $data);
        static::assertTrue($data->isEmpty());
    }

    public function testFactoryCreatesEmptyToManyDataWhenEmptyArrayDataGiven(): void
    {
        $data = $this->factory->make('type', true, []);
        static::assertInstanceOf(ToManyRelationshipData::class, $data);
        static::assertTrue($data->isEmpty());
    }

    public function testFactoryCreatesEmptyToOneDataWhenNullDataGiven(): void
    {
        $data = $this->factory->make('type', false, null);
        static::assertInstanceOf(ToOneRelationshipData::class, $data);
        static::assertTrue($data->isEmpty());
    }

    public function testFactoryRaisesAnExceptionWhenTryingToCreateToOneRelationshipDataWithArrayData(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->factory->make('type', false, ['1', '2', '3']);
    }

    public function testFactoryRaisesAnExceptionWhenTryingToCreateToManyRelationshipDataWithStringData(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->factory->make('type', true, '1');
    }

    public function testFactoryRaisesAnExceptionWhenTryingToCreateToManyRelationshipDataWithNonStringArrayData(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->factory->make('type', true, ['1', 2, 3]);
    }

    public function testFactoryCreatesToManyData(): void
    {
        $data = $this->factory->make('type', true, ['1', '2', '3']);
        static::assertInstanceOf(ToManyRelationshipData::class, $data);
        static::assertFalse($data->isEmpty());

        $ids = $data->getData()->getResourceIdentifiers();
        static::assertCount(3, $ids);
        $types = [];

        array_walk($ids, static function (ResourceIdentifierInterface &$item) use (&$types): void {
            $types[] = $item->getType();
            $item = $item->getId();
        });

        static::assertEquals(['1', '2', '3'], $ids);
        static::assertEquals(['type'], array_unique($types));
    }

    public function testFactoryCreatesToOneData(): void
    {
        $data = $this->factory->make('type', false, '1');
        static::assertInstanceOf(ToOneRelationshipData::class, $data);
        static::assertFalse($data->isEmpty());

        static::assertInstanceOf(ResourceIdentifierInterface::class, $data->getData());

        static::assertEquals('1', $data->getData()->getId());
        static::assertEquals('type', $data->getData()->getType());
    }
}
