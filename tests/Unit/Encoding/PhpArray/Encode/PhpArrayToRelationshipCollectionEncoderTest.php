<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\PhpArrayToLinkCollectionEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArrayToRelationshipCollectionEncoder;
use Undabot\JsonApi\Model\Resource\Relationship\Data\ToManyRelationshipData;
use Undabot\JsonApi\Model\Resource\Relationship\Relationship;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;

class PhpArrayToRelationshipCollectionEncoderTest extends TestCase
{
    /** @var PhpArrayToRelationshipCollectionEncoder */
    private $encoder;

    public function setUp(): void
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

        $relationshipsCollection = $this->encoder->decode($emptyRelationshipsArray);

        $this->assertCount(1, $relationshipsCollection);

        /** @var Relationship $singleRelationship */
        $singleRelationship = $relationshipsCollection->getRelationshipByName('fakeResourceName');

        /** @var ToManyRelationshipData $relationshipData */
        $relationshipData = $singleRelationship->getData();

        $this->assertInstanceOf(ToManyRelationshipData::class, $relationshipData);

        /** @var ToManyRelationshipData $relationships */
        $relationships = $singleRelationship->getData();

        $this->assertTrue($relationships->isEmpty());
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

        $relationshipsCollection = $this->encoder->decode($validRelationshipsArray);

        /** @var Relationship singleRelationship */
        $singleRelationship = $relationshipsCollection->getRelationshipByName('fakeResourceName');

        $this->assertCount(1, $relationshipsCollection->getRelationships());

        /** @var ToManyRelationshipData relationshipData */
        $relationshipData = $singleRelationship->getData();

        $this->assertInstanceOf(ToManyRelationshipData::class, $relationshipData);

        /** @var ToManyRelationshipData $relationships */
        $relationships = $singleRelationship->getData();

        $this->assertCount(3, $relationships->getData());
    }

    public function testMissingRelationshipTypeRaisesException(): void
    {
        $invalidRelationshipArray = [
            'fakeResourceName' => [
                'type' => 'fakeResourceNames',
                'data' => [
                    ['id' => 'rand-str-Id-1'],
                    ['id' => 'rand-str-Id-2', 'type' => 'fakeResourceName'],
                    ['id' => 'rand-str-Id-3', 'type' => 'fakeResourceName'],
                ],
            ],
        ];

        $this->expectException(AssertException::class);
        $this->expectExceptionMessage('Resource identifier must have `id` and `type` keys');
        $this->encoder->decode($invalidRelationshipArray);
    }
}
