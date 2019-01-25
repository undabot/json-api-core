<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Relationship;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Resource\Relationship\Relationship;

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
}
