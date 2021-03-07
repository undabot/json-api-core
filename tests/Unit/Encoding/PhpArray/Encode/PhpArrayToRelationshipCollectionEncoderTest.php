<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToLinkCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;
use Undabot\JsonApi\Implementation\Encoding\PhpArrayToRelationshipCollectionEncoder;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Implementation\Model\Resource\Relationship\Relationship;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Encoding\PhpArrayToRelationshipCollectionEncoder
 *
 * @small
 */
final class PhpArrayToRelationshipCollectionEncoderTest extends TestCase
{
    private PhpArrayToRelationshipCollectionEncoder $encoder;

    protected function setUp(): void
    {
        $phpArrayToMetaEncoder = $this->createMock(PhpArrayToMetaEncoderInterface::class);
        $phpArrayToLinkCollectionEncoder = $this->createMock(PhpArrayToLinkCollectionEncoderInterface::class);

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

        /** @var Relationship singleRelationship */
        $singleRelationship = $relationshipsCollection->getRelationshipByName('fakeResourceName');

        static::assertCount(1, $relationshipsCollection->getRelationships());

        /** @var ToManyRelationshipData relationshipData */
        $relationshipData = $singleRelationship->getData();

        static::assertInstanceOf(ToManyRelationshipData::class, $relationshipData);

        /** @var ToManyRelationshipData $relationships */
        $relationships = $singleRelationship->getData();

        static::assertCount(3, $relationships->getData());
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
}
