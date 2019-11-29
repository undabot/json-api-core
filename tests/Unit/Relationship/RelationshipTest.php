<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Relationship;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Relationship;

class RelationshipTest extends TestCase
{
    private $relationshipName;
    /** @var MockObject|LinkCollectionInterface */
    private $linksCollection;

    public function setUp()
    {
        $this->relationshipName = 'relationshipName';
        $this->linksCollection = $this->createMock(LinkCollectionInterface::class);

        $this->linksCollection->method('getIterator')->willReturn(new \ArrayIterator());
    }

    public function testRelationshipCanBeCreatedWithValidLinkCollection(): void
    {
        $relationship = new Relationship('relationshipName', $this->linksCollection);

        $this->assertInstanceOf(Relationship::class, $relationship);
    }

    public function testItCannotBeCreatedWithInvalidLinkCollection(): void
    {
        $this->linksCollection->method('getLinkNames')->willReturn(['invalid+']);

        $this->expectException(\InvalidArgumentException::class);

        new Relationship($this->relationshipName, $this->linksCollection);
    }

    public function testToOneRelationshipDataCanBeCreatedEmpty(): void
    {
        $emptyToOneRelationshipData = ToOneRelationshipData::makeEmpty();

        $this->assertTrue($emptyToOneRelationshipData->isEmpty());
    }

    public function testToManyRelationshipDataCanBeCreatedEmpty(): void
    {
        $emptyToManyRelationshipData = ToManyRelationshipData::makeEmpty();

        $this->assertTrue($emptyToManyRelationshipData->isEmpty());
    }

    public function testRelationshipCanBeCreatedWithNoData(): void
    {
        $emptyToOneRelationshipData = ToOneRelationshipData::makeEmpty();

        $emptyRelationship = new Relationship('relationship', $nullLinkCollection = null, $emptyToOneRelationshipData);

        /** @var ToOneRelationshipData $relationshipData */
        $relationshipData = $emptyRelationship->getData();

        $this->assertTrue($relationshipData->isEmpty());
    }
}
