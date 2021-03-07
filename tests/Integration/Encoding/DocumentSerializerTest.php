<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Integration\Encoding;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\DocumentToPhpArrayEncoderInterface;
use Undabot\JsonApi\Implementation\Encoding\AttributeCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ErrorCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ErrorToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\LinkCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\LinkToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\MetaToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\RelationshipCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\RelationshipToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ResourceCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ResourceIdentifierCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ResourceIdentifierToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\ResourceToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Encoding\SourceToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Model\Document\Document;
use Undabot\JsonApi\Implementation\Model\Document\DocumentData;
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
use Undabot\JsonApi\Implementation\Model\Resource\ResourceCollection;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifier;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifierCollection;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder
 *
 * @small
 */
final class DocumentSerializerTest extends TestCase
{
    private DocumentToPhpArrayEncoderInterface $serializer;

    protected function setUp(): void
    {
        $metaSerializer = new MetaToPhpArrayEncoder();
        $linkSerializer = new LinkToPhpArrayEncoder($metaSerializer);
        $linksSerializer = new LinkCollectionToPhpArrayEncoder($linkSerializer);

        $resourceSerializer = new ResourceToPhpArrayEncoder(
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

        $resourceIdentifierEncoder = new ResourceIdentifierToPhpArrayEncoder(
            $metaSerializer
        );

        $this->serializer = new DocumentToPhpArrayEncoder(
            new DocumentDataToPhpArrayEncoder(
                $resourceSerializer,
                new ResourceCollectionToPhpArrayEncoder($resourceSerializer),
                new ResourceIdentifierToPhpArrayEncoder($metaSerializer),
                new ResourceIdentifierCollectionToPhpArrayEncoder($resourceIdentifierEncoder),
            ),
            new ErrorCollectionToPhpArrayEncoder(new ErrorToPhpArrayEncoder(
                $linkSerializer,
                new SourceToPhpArrayEncoder(),
                $metaSerializer
            )),
            new MetaToPhpArrayEncoder(),
            new LinkCollectionToPhpArrayEncoder(
                new LinkToPhpArrayEncoder(
                    new MetaToPhpArrayEncoder()
                )
            ),
            new ResourceCollectionToPhpArrayEncoder($resourceSerializer)
        );
    }

    public function testSimpleDocumentIsSerializedCorrectly(): void
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
        $expectedJson = <<<'JSON'
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

        static::assertJsonStringEqualsJsonString($expectedJson, (string) $serializedJson);
    }

    public function testDocumentWithIncludedResourcesIsSerializedCorrectly(): void
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
                                    new Link(
                                        'self',
                                        new LinkUrl('http://example.com/articles/1/relationships/comments')
                                    ),
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

        $expectedJson = <<<'JSON'
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

        static::assertJsonStringEqualsJsonString($expectedJson, (string) $serializedJson);
    }
}
