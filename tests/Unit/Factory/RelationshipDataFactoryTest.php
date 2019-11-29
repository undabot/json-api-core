<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Factory;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Implementation\Factory\RelationshipDataFactory;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;

class RelationshipDataFactoryTest extends TestCase
{
    /** @var RelationshipDataFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new RelationshipDataFactory();
    }

    public function testFactoryCreatesEmptyToManyDataWhenNullDataGiven(): void
    {
        $data = $this->factory->make('type', true, null);
        $this->assertInstanceOf(ToManyRelationshipData::class, $data);
        $this->assertTrue($data->isEmpty());
    }

    public function testFactoryCreatesEmptyToManyDataWhenEmptyArrayDataGiven(): void
    {
        $data = $this->factory->make('type', true, []);
        $this->assertInstanceOf(ToManyRelationshipData::class, $data);
        $this->assertTrue($data->isEmpty());
    }

    public function testFactoryCreatesEmptyToOneDataWhenNullDataGiven(): void
    {
        $data = $this->factory->make('type', false, null);
        $this->assertInstanceOf(ToOneRelationshipData::class, $data);
        $this->assertTrue($data->isEmpty());
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
        $this->assertInstanceOf(ToManyRelationshipData::class, $data);
        $this->assertFalse($data->isEmpty());

        $ids = $data->getData()->getResourceIdentifiers();
        $this->assertCount(3, $ids);
        $types = [];

        array_walk($ids, function (ResourceIdentifierInterface &$item) use (&$types) {
            $types[] = $item->getType();
            $item = $item->getId();
        });

        $this->assertEquals(['1', '2', '3'], $ids);
        $this->assertEquals(['type'], array_unique($types));
    }

    public function testFactoryCreatesToOneData(): void
    {
        $data = $this->factory->make('type', false, '1');
        $this->assertInstanceOf(ToOneRelationshipData::class, $data);
        $this->assertFalse($data->isEmpty());

        $this->assertInstanceOf(ResourceIdentifierInterface::class, $data->getData());

        $this->assertEquals('1', $data->getData()->getId());
        $this->assertEquals('type', $data->getData()->getType());
    }
}
