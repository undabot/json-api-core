<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Model\Document;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Model\Document\DocumentData;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Document\DocumentData
 *
 * @small
 */
final class DocumentDataTest extends TestCase
{
    public function testItCanBeConstructedWithNullArgument(): void
    {
        $documentData = new DocumentData(null);

        static::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithEmptyArrayArgument(): void
    {
        $documentData = new DocumentData([]);

        static::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceArgument(): void
    {
        $resourceMock = $this->createMock(ResourceInterface::class);

        $documentData = new DocumentData($resourceMock);

        static::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceIdentifierArgument(): void
    {
        $resourceIdentifierMock = $this->createMock(ResourceIdentifierInterface::class);

        $documentData = new DocumentData($resourceIdentifierMock);

        static::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceCollectionArgument(): void
    {
        $resourceCollectionMock = $this->createMock(ResourceCollectionInterface::class);

        $documentData = new DocumentData($resourceCollectionMock);

        static::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceIdentifierCollectionArgument(): void
    {
        $resourceIdentifierCollectionMock = $this->createMock(ResourceIdentifierCollectionInterface::class);

        $documentData = new DocumentData($resourceIdentifierCollectionMock);

        static::assertInstanceOf(DocumentData::class, $documentData);
    }

    /**
     * @dataProvider provideInvalidConstructorArguments
     *
     * @param mixed $invalidArgument
     */
    public function testItWillThrowExceptionIfConstructedWithInvalidArgument($invalidArgument): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new DocumentData($invalidArgument);
    }

    public function testGetResourceWillReturnDataIfDataIsTypeOfResource(): void
    {
        /** @var ResourceInterface $resourceMock */
        $resourceMock = $this->createMock(ResourceInterface::class);

        $document = new DocumentData($resourceMock);

        static::assertInstanceOf(ResourceInterface::class, $document->getResource());
    }

    public function testGetResourceCollectionWillReturnDataIfDataIsTypeOfResourceCollection(): void
    {
        /** @var ResourceCollectionInterface $resourceCollectionMock */
        $resourceCollectionMock = $this->createMock(ResourceCollectionInterface::class);

        $document = new DocumentData($resourceCollectionMock);

        static::assertInstanceOf(ResourceCollectionInterface::class, $document->getResourceCollection());
    }

    public function testGetResourceWillThrowExceptionIfDataIsNotTypeOfResource(): void
    {
        /** @var ResourceCollectionInterface $resourceCollectionMock */
        $resourceCollectionMock = $this->createMock(ResourceCollectionInterface::class);

        $document = new DocumentData($resourceCollectionMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Data is not Resource');

        $document->getResource();
    }

    public function testGetResourceCollectionWillThrowExceptionIfDataIsNotTypeOfResourceCollection(): void
    {
        /** @var ResourceInterface $resourceMock */
        $resourceMock = $this->createMock(ResourceInterface::class);

        $document = new DocumentData($resourceMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Data is not Resource Collection');

        $document->getResourceCollection();
    }

    public function provideInvalidConstructorArguments()
    {
        return [
            [''], // empty string
            ['string'], // string
            [1], // integer
            [1.345], // float
            [['value']], // non-empty array
            [[[]]], // empty nested array
            [new \stdClass()], // object
        ];
    }
}
