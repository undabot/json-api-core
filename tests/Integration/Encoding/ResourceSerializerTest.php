<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Integration\Encoding;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Implementation\Encoding\AttributeCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\LinkCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\LinkToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\MetaToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\RelationshipCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\RelationshipToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ResourceIdentifierToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ResourceToPhpArrayEncoder;
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
 * @covers \Undabot\JsonApi\Implementation\Encoding\ResourceToPhpArrayEncoder
 *
 * @small
 */
final class ResourceSerializerTest extends TestCase
{
    private ResourceToPhpArrayEncoderInterface $serializer;

    protected function setUp(): void
    {
        $metaSerializer = new MetaToPhpArrayEncoder();
        $linkSerializer = new LinkToPhpArrayEncoder($metaSerializer);
        $linksSerializer = new LinkCollectionToPhpArrayEncoder($linkSerializer);

        $this->serializer = new ResourceToPhpArrayEncoder(
            $metaSerializer,
            new RelationshipCollectionToPhpArrayEncoder(
                new RelationshipToPhpArrayEncoder(
                    $metaSerializer,
                    $linksSerializer,
                    new ResourceIdentifierToPhpArrayEncoder($metaSerializer)
                )
            ),
            $linkSerializer,
            new AttributeCollectionToPhpArrayEncoder()
        );
    }

    public function testSimpleResourceCanBeSerialized(): void
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

        $serialized = $this->serializer->encode($resource);

        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $expectedJson = <<<'JSON'
            {
                "type": "articles",
                "id": "1",
                "attributes": {
                    "title": "Rails is Omakase"
                },
                "relationships": {
                    "author": {
                        "links": {
                            "self": "/articles/1/relationships/author",
                            "related": "/articles/1/author"
                        },
                        "data": {
                            "type": "people",
                            "id": "9"
                        }
                    }
                }
            }
            JSON;

        static::assertEquals($expectedJson, $serializedJson);
    }

    public function testComplexResourceCanBeSerialized(): void
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

        $serialized = $this->serializer->encode($resource);

        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $expectedJson = <<<'JSON'
            {
                "type": "articles",
                "id": "1",
                "attributes": {
                    "title": "JSON:API paints my bikeshed!"
                },
                "links": {
                    "self": "http://example.com/articles/1"
                },
                "relationships": {
                    "author": {
                        "links": {
                            "self": "http://example.com/articles/1/relationships/author",
                            "related": "http://example.com/articles/1/author"
                        },
                        "data": {
                            "type": "people",
                            "id": "9"
                        }
                    },
                    "comments": {
                        "links": {
                            "self": "http://example.com/articles/1/relationships/comments",
                            "related": "http://example.com/articles/1/comments"
                        },
                        "data": [
                            {
                                "type": "comments",
                                "id": "5"
                            },
                            {
                                "type": "comments",
                                "id": "12"
                            }
                        ]
                    }
                }
            }
            JSON;

        static::assertEquals($expectedJson, $serializedJson);
    }
}
