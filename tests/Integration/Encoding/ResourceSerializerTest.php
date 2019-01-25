<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Integration\Encoding;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\PhpArray\Encode\AttributeCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\LinkCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\LinkPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\MetaPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\RelationshipCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\RelationshipPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceIdentifierPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourcePhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourcePhpArrayEncoderInterface;
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

class ResourceSerializerTest extends TestCase
{
    /** @var ResourcePhpArrayEncoderInterface */
    private $serializer;

    protected function setUp()
    {
        $metaSerializer = new MetaPhpArrayEncoder();
        $linkSerializer = new LinkPhpArrayEncoder($metaSerializer);
        $linksSerializer = new LinkCollectionPhpArrayEncoder($linkSerializer);

        $this->serializer = new ResourcePhpArrayEncoder(
            $metaSerializer,
            new RelationshipCollectionPhpArrayEncoder(new RelationshipPhpArrayEncoder(
                    $metaSerializer, $linksSerializer, new ResourceIdentifierPhpArrayEncoder($metaSerializer))
            ),
            $linkSerializer,
            new AttributeCollectionPhpArrayEncoder()
        );
    }

    public function testSimpleResourceCanBeSerialized()
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
        $expectedJson = <<<JSON
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

        $this->assertEquals($expectedJson, $serializedJson);
    }

    public function testComplexResourceCanBeSerialized()
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
        $expectedJson = <<<JSON
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

        $this->assertEquals($expectedJson, $serializedJson);
    }
}
