<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Relationship;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Relationship;

/**
 * @internal
 */
#[CoversClass(Relationship::class)]
#[Small]
final class RelationshipTest extends TestCase
{
    private string $relationshipName;
    private Stub $linksCollection;

    protected function setUp(): void
    {
        $this->relationshipName = 'relationshipName';
        $this->linksCollection = self::createStub(LinkCollectionInterface::class);

        $this->linksCollection->method('getIterator')->willReturn(new \ArrayIterator());
    }

    public function testRelationshipCanBeCreatedWithValidLinkCollection(): void
    {
        $relationship = new Relationship('relationshipName', $this->linksCollection);

        self::assertInstanceOf(Relationship::class, $relationship);
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

        self::assertTrue($emptyToOneRelationshipData->isEmpty());
    }

    public function testToManyRelationshipDataCanBeCreatedEmpty(): void
    {
        $emptyToManyRelationshipData = ToManyRelationshipData::makeEmpty();

        self::assertTrue($emptyToManyRelationshipData->isEmpty());
    }

    public function testRelationshipCanBeCreatedWithNoData(): void
    {
        $emptyToOneRelationshipData = ToOneRelationshipData::makeEmpty();

        $emptyRelationship = new Relationship('relationship', $nullLinkCollection = null, $emptyToOneRelationshipData);

        /** @var ToOneRelationshipData $relationshipData */
        $relationshipData = $emptyRelationship->getData();

        self::assertTrue($relationshipData->isEmpty());
    }
}
