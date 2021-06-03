<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\Relationship\RelationshipCollectionInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;
use Undabot\JsonApi\Implementation\Encoding\PhpArrayToLinkCollectionEncoder;
use Undabot\JsonApi\Implementation\Encoding\PhpArrayToMetaEncoder;
use Undabot\JsonApi\Implementation\Encoding\PhpArrayToRelationshipCollectionEncoder;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Relationship;
use Undabot\JsonApi\Implementation\Model\Resource\ResourceIdentifier;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Encoding\PhpArrayToRelationshipCollectionEncoder
 *
 * @small
 */
final class PhpArrayToRelationshipCollectionEncoderTest extends TestCase
{
    /** @var PhpArrayToRelationshipCollectionEncoder $encoder */
    private $encoder;

    protected function setUp(): void
    {
        $phpArrayToMetaEncoder = new PhpArrayToMetaEncoder();
        $phpArrayToLinkCollectionEncoder = new PhpArrayToLinkCollectionEncoder();

        $this->encoder = new PhpArrayToRelationshipCollectionEncoder(
            $phpArrayToMetaEncoder,
            $phpArrayToLinkCollectionEncoder
        );
    }

    public function testValidEmptyRelationshipsArrayIsEncodedToRelationshipsCollection(): void
    {
        $emptyRelationshipsArray = [
            'fakeResourceName' => [
                'type' => 'fakeResourceNames',
                'data' => [],
            ],
        ];

        $relationshipsCollection = $this->encoder->encode($emptyRelationshipsArray);

        static::assertCount(1, $relationshipsCollection);

        /** @var Relationship $singleRelationship */
        $singleRelationship = $relationshipsCollection->getRelationshipByName('fakeResourceName');

        /** @var ToManyRelationshipData $relationshipData */
        $relationshipData = $singleRelationship->getData();

        static::assertInstanceOf(ToManyRelationshipData::class, $relationshipData);

        /** @var ToManyRelationshipData $relationships */
        $relationships = $singleRelationship->getData();

        static::assertTrue($relationships->isEmpty());
    }

    public function testValidRelationshipsArrayIsEncodedToRelationshipsCollection(): void
    {
        $validRelationshipsArray = [
            'fakeResourceName' => [
                'type' => 'fakeResourceNames',
                'data' => [
                    ['id' => 'rand-str-Id-1', 'type' => 'fakeResourceName'],
                    ['id' => 'rand-str-Id-2', 'type' => 'fakeResourceName'],
                    ['id' => 'rand-str-Id-3', 'type' => 'fakeResourceName'],
                ],
            ],
        ];

        $relationshipsCollection = $this->encoder->encode($validRelationshipsArray);

        $this->validateRelationship($relationshipsCollection, 'fakeResourceName');

        /** @var ResourceIdentifier $resourceIdentifier */
        foreach ($relationshipsCollection->getRelationshipByName('fakeResourceName')->getData()->getData()->getResourceIdentifiers() as $resourceIdentifier) {
            static::assertInstanceOf(ResourceIdentifier::class, $resourceIdentifier);
            static::assertNull($resourceIdentifier->getMeta());
        }
    }

    public function testValidRelationshipsArrayIsEncodedToRelationshipsCollectionWithMetaAttributesGiven(): void
    {
        $validRelationshipsArray = [
            'fakeResourceName' => [
                'type' => 'fakeResourceNames',
                'data' => [
                    ['id' => 'rand-str-Id-1', 'type' => 'fakeResourceName', 'meta' => []],
                    ['id' => 'rand-str-Id-2', 'type' => 'fakeResourceName', 'meta' => ['foo' => 'bar']],
                    ['id' => 'rand-str-Id-3', 'type' => 'fakeResourceName', 'meta' => ['foo' => ['bar' => 'baz']]],
                ],
            ],
        ];

        $relationshipsCollection = $this->encoder->encode($validRelationshipsArray);

        $this->validateRelationship($relationshipsCollection, 'fakeResourceName');

        /** @var array<int,ResourceIdentifier> $resourceIdentifiers */
        $resourceIdentifiers = $relationshipsCollection->getRelationshipByName('fakeResourceName')->getData()->getData()->getResourceIdentifiers();
        $firstResourceIdentifier = $resourceIdentifiers[0] ?? null;
        $secondResourceIdentifier = $resourceIdentifiers[1] ?? null;
        $thirdResourceIdentifier = $resourceIdentifiers[2] ?? null;
        static::assertInstanceOf(ResourceIdentifier::class, $firstResourceIdentifier);
        static::assertInstanceOf(ResourceIdentifier::class, $secondResourceIdentifier);
        static::assertInstanceOf(ResourceIdentifier::class, $thirdResourceIdentifier);
        static::assertSame([], $firstResourceIdentifier->getMeta()->getData());
        static::assertSame(['foo' => 'bar'], $secondResourceIdentifier->getMeta()->getData());
        static::assertSame(['foo' => ['bar' => 'baz']], $thirdResourceIdentifier->getMeta()->getData());
    }

    public function testMissingRelationshipTypeRaisesException(): void
    {
        $invalidRelationshipArray = [
            'fakeResourceName' => [
                'type' => 'fakeResourceNames',
                'data' => [
                    ['id' => 'rand-str-Id-1'],
                ],
            ],
        ];

        $this->expectException(JsonApiEncodingException::class);
        $this->expectExceptionMessage('Resource identifier must have key `type`');
        $this->encoder->encode($invalidRelationshipArray);
    }

    public function testMissingRelationshipIdRaisesException(): void
    {
        $invalidRelationshipArray = [
            'fakeResourceName' => [
                'type' => 'fakeResourceNames',
                'data' => [
                    ['type' => 'rand-str-Id-1'],
                ],
            ],
        ];

        $this->expectException(JsonApiEncodingException::class);
        $this->expectExceptionMessage('Resource identifier must have key `id`');
        $this->encoder->encode($invalidRelationshipArray);
    }

    private function validateRelationship(RelationshipCollectionInterface $relationshipsCollection, string $relationshipName): void
    {
        /** @var Relationship $singleRelationship */
        $singleRelationship = $relationshipsCollection->getRelationshipByName($relationshipName);

        static::assertCount(1, $relationshipsCollection->getRelationships());

        /** @var ToManyRelationshipData $relationshipData */
        $relationshipData = $singleRelationship->getData();

        static::assertInstanceOf(ToManyRelationshipData::class, $relationshipData);

        /** @var ToManyRelationshipData $relationships */
        $relationships = $singleRelationship->getData();

        static::assertCount(3, $relationships->getData());
    }
}
