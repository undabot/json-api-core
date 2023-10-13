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
 *
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
        self::assertInstanceOf(ToManyRelationshipData::class, $data);
        self::assertTrue($data->isEmpty());
    }

    public function testFactoryCreatesEmptyToManyDataWhenEmptyArrayDataGiven(): void
    {
        $data = $this->factory->make('type', true, []);
        self::assertInstanceOf(ToManyRelationshipData::class, $data);
        self::assertTrue($data->isEmpty());
    }

    public function testFactoryCreatesEmptyToOneDataWhenNullDataGiven(): void
    {
        $data = $this->factory->make('type', false, null);
        self::assertInstanceOf(ToOneRelationshipData::class, $data);
        self::assertTrue($data->isEmpty());
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
        self::assertInstanceOf(ToManyRelationshipData::class, $data);
        self::assertFalse($data->isEmpty());

        $ids = $data->getData()->getResourceIdentifiers();
        self::assertCount(3, $ids);
        $types = [];

        array_walk($ids, static function (ResourceIdentifierInterface &$item) use (&$types): void {
            $types[] = $item->getType();
            $item = $item->getId();
        });

        self::assertEquals(['1', '2', '3'], $ids);
        self::assertEquals(['type'], array_unique($types));
    }

    public function testFactoryCreatesToOneData(): void
    {
        $data = $this->factory->make('type', false, '1');
        self::assertInstanceOf(ToOneRelationshipData::class, $data);
        self::assertFalse($data->isEmpty());

        self::assertInstanceOf(ResourceIdentifierInterface::class, $data->getData());

        self::assertEquals('1', $data->getData()->getId());
        self::assertEquals('type', $data->getData()->getType());
    }
}
