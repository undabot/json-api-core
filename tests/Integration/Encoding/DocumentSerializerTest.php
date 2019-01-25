<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Integration\Encoding;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\PhpArray\Encode\AttributeCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\DocumentDataPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\DocumentPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\DocumentPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ErrorCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ErrorPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\LinkCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\LinkPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\MetaPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\RelationshipCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\RelationshipPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceIdentifierCollectionPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceIdentifierPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourcePhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\SourcePhpArrayEncoder;
use Undabot\JsonApi\Model\Document\Document;
use Undabot\JsonApi\Model\Document\DocumentData;
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
use Undabot\JsonApi\Model\Resource\ResourceCollection;
use Undabot\JsonApi\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollection;

class DocumentSerializerTest extends TestCase
{
    /** @var DocumentPhpArrayEncoderInterface */
    private $serializer;

    protected function setUp()
    {
        $metaSerializer = new MetaPhpArrayEncoder();
        $linkSerializer = new LinkPhpArrayEncoder($metaSerializer);
        $linksSerializer = new LinkCollectionPhpArrayEncoder($linkSerializer);

        $resourceSerializer = new ResourcePhpArrayEncoder(
            $metaSerializer,
            new RelationshipCollectionPhpArrayEncoder(new RelationshipPhpArrayEncoder(
                    $metaSerializer, $linksSerializer, new ResourceIdentifierPhpArrayEncoder($metaSerializer))
            ),
            $linkSerializer,
            new AttributeCollectionPhpArrayEncoder()
        );

        $resourceIdentifierEncoder = new ResourceIdentifierPhpArrayEncoder(
            $metaSerializer
        );

        $this->serializer = new DocumentPhpArrayEncoder(
            new DocumentDataPhpArrayEncoder(
                $resourceSerializer,
                new ResourceCollectionPhpArrayEncoder($resourceSerializer),
                new ResourceIdentifierPhpArrayEncoder($metaSerializer),
                new ResourceIdentifierCollectionPhpArrayEncoder($resourceIdentifierEncoder),
                ),
            new ErrorCollectionPhpArrayEncoder(new ErrorPhpArrayEncoder($linkSerializer, new SourcePhpArrayEncoder(),
                $metaSerializer)),
            new MetaPhpArrayEncoder(),
            new LinkCollectionPhpArrayEncoder(
                new LinkPhpArrayEncoder(
                    new MetaPhpArrayEncoder()
                )
            ),
            new ResourceCollectionPhpArrayEncoder($resourceSerializer)
        );
    }

    public function testSimpleDocumentIsSerializedCorrectly()
    {
        $document = new Document(
            new DocumentData(
                new ResourceCollection([
                    new Resource(
                        '1',
                        'articles',
                        new AttributeCollection([
                            new Attribute('title', 'JSON:API paints my bikeshed!'),
                            new Attribute('body', 'The shortest article. Ever.'),
                            new Attribute('created', '2015-05-22T14:56:29.000Z'),
                            new Attribute('updated', '2015-05-22T14:56:28.000Z'),
                        ]),
                        new RelationshipCollection([
                            new Relationship(
                                'author',
                                null,
                                ToOneRelationshipData::make(new ResourceIdentifier('42', 'people'))
                            ),
                        ])
                    ),
                ])
            )
        );

        $serialized = $this->serializer->encode($document);
        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT);
        $expectedJson = <<<JSON
{
    "data": [
        {
            "type": "articles",
            "id": "1",
            "attributes": {
                "title": "JSON:API paints my bikeshed!",
                "body": "The shortest article. Ever.",
                "created": "2015-05-22T14:56:29.000Z",
                "updated": "2015-05-22T14:56:28.000Z"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "42"
                    }
                }
            }
        }
    ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expectedJson, (string) $serializedJson);
    }

    public function testDocumentWithIncludedResourcesIsSerializedCorrectly()
    {
        $document = new Document(
            new DocumentData(
                new ResourceCollection([
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
                                    new Link('self',
                                        new LinkUrl('http://example.com/articles/1/relationships/comments')),
                                    new Link('related', new LinkUrl('http://example.com/articles/1/comments')),
                                ]),
                                new ToManyRelationshipData(new ResourceIdentifierCollection([
                                    new ResourceIdentifier('5', 'comments'),
                                    new ResourceIdentifier('12', 'comments'),
                                ]))
                            ),
                        ]),
                        new Link('self', new LinkUrl('http://example.com/articles/1'))
                    ),
                ])
            ),
            null,
            null,
            null,
            null,
            new ResourceCollection([
                new Resource(
                    '9',
                    'people',
                    new AttributeCollection([
                        new Attribute('first-name', 'Dan'),
                        new Attribute('last-name', 'Gebhardt'),
                        new Attribute('twitter', 'dgeb'),
                    ]),
                    null,
                    new Link('self', new LinkUrl('http://example.com/people/9'))
                ),
                new Resource(
                    '5',
                    'comments',
                    new AttributeCollection([
                        new Attribute('body', 'First!'),
                    ]),
                    new RelationshipCollection([
                        new Relationship(
                            'author',
                            null,
                            ToOneRelationshipData::make(new ResourceIdentifier('2', 'people'))
                        ),
                    ]),
                    new Link('self', new LinkUrl('http://example.com/comments/5'))
                ),
                new Resource(
                    '12',
                    'comments',
                    new AttributeCollection([
                        new Attribute('body', 'I like XML better'),
                    ]),
                    new RelationshipCollection([
                        new Relationship(
                            'author',
                            null,
                            ToOneRelationshipData::make(new ResourceIdentifier('9', 'people'))
                        ),
                    ]),
                    new Link('self', new LinkUrl('http://example.com/comments/12'))
                ),
            ])
        );

        $serialized = $this->serializer->encode($document);
        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $expectedJson = <<<JSON
{
    "data": [
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
    ],
    "included": [
        {
            "type": "people",
            "id": "9",
            "attributes": {
                "first-name": "Dan",
                "last-name": "Gebhardt",
                "twitter": "dgeb"
            },
            "links": {
                "self": "http://example.com/people/9"
            }
        },
        {
            "type": "comments",
            "id": "5",
            "attributes": {
                "body": "First!"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "2"
                    }
                }
            },
            "links": {
                "self": "http://example.com/comments/5"
            }
        },
        {
            "type": "comments",
            "id": "12",
            "attributes": {
                "body": "I like XML better"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "9"
                    }
                }
            },
            "links":{
                "self": "http://example.com/comments/12"
            }
        }
    ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expectedJson, (string) $serializedJson);
    }
}
