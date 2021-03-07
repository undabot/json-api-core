<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Resource;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Implementation\Model\Link\Link;
use Undabot\JsonApi\Implementation\Model\Link\LinkCollection;
use Undabot\JsonApi\Implementation\Model\Link\LinkUrl;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\Attribute;
use Undabot\JsonApi\Implementation\Model\Resource\Attribute\AttributeCollection;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToOneRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Relationship;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\RelationshipCollection;
use Undabot\JsonApi\Implementation\Model\Resource\Resource;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifierCollection;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Resource\Resource
 *
 * @small
 */
final class ResourceCreationTest extends TestCase
{
    public function testICanCreateSimpleResource(): void
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

        static::assertSame('1', $resource->getId());
        static::assertSame('articles', $resource->getType());
        static::assertNotNull($resource->getAttributes());
        static::assertNotNull($resource->getRelationships());
        static::assertNull($resource->getMeta());
    }

    public function testICanCreateComplexResource(): void
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

        static::assertSame('1', $resource->getId());
        static::assertSame('articles', $resource->getType());
        static::assertNotNull($resource->getAttributes());
        static::assertNotNull($resource->getRelationships());
        static::assertNull($resource->getMeta());
    }
}
