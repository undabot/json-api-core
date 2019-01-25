<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Resource;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Model\Link\Link;
use Undabot\JsonApi\Model\Link\LinkCollection;
use Undabot\JsonApi\Model\Link\LinkUrl;
use Undabot\JsonApi\Model\Resource\Attribute\Attribute;
use Undabot\JsonApi\Model\Resource\Attribute\AttributeCollection;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Model\Resource\Relationship\Relationship;
use Undabot\JsonApi\Model\Resource\Relationship\RelationshipCollection;
use Undabot\JsonApi\Model\Resource\Resource;
use Undabot\JsonApi\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollection;

class ResourceCreationTest extends TestCase
{
    public function testICanCreateSimpleResource()
    {
        $resource = new Resource(
            '1',
            'articles',
            new AttributeCollection([
                new Attribute('title', 'Rails is Omakase'),
            ]),
            new RelationshipCollection([
                new Relationship(
                    'author',
                    new LinkCollection([
                        new Link('self', new LinkUrl('/articles/1/relationships/author')),
                        new Link('related', new LinkUrl('/articles/1/author')),
                    ]),
                    ToOneRelationshipData::make(new ResourceIdentifier('9', 'people'))
                ),
            ])
        );

        $this->assertSame('1', $resource->getId());
        $this->assertSame('articles', $resource->getType());
        $this->assertNotNull($resource->getAttributes());
        $this->assertNotNull($resource->getRelationships());
        $this->assertNull($resource->getMeta());
    }

    public function testICanCreateComplexResource()
    {
        $resource = new Resource(
            '1',
            'articles',
            new AttributeCollection([
                new Attribute('title', 'JSON:API paints my bikeshed!'),
            ]),
            new RelationshipCollection([
                new Relationship(
                    'author',
                    new LinkCollection([
                        new Link('self', new LinkUrl('http://example.com/articles/1/relationships/author')),
                        new Link('related', new LinkUrl('http://example.com/articles/1/author')),
                    ]),
                    ToOneRelationshipData::make(new ResourceIdentifier('9', 'people'))
                ),
                new Relationship(
                    'comments',
                    new LinkCollection([
                        new Link('self', new LinkUrl('http://example.com/articles/1/relationships/comments')),
                        new Link('related', new LinkUrl('http://example.com/articles/1/comments')),
                    ]),
                    new ToManyRelationshipData(new ResourceIdentifierCollection([
                        new ResourceIdentifier('5', 'comments'),
                        new ResourceIdentifier('12', 'comments'),
                    ]))
                ),
            ]),
            new Link('self', new LinkUrl('http://example.com/articles/1'))
        );

        $this->assertSame('1', $resource->getId());
        $this->assertSame('articles', $resource->getType());
        $this->assertNotNull($resource->getAttributes());
        $this->assertNotNull($resource->getRelationships());
        $this->assertNull($resource->getMeta());
    }
}
