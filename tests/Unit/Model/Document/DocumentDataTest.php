<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Model\Document;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Model\Document\DocumentData;

/**
 * @internal
 */
#[CoversClass(DocumentData::class)]
#[Small]
final class DocumentDataTest extends TestCase
{
    public function testItCanBeConstructedWithNullArgument(): void
    {
        $documentData = new DocumentData(null);

        self::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithEmptyArrayArgument(): void
    {
        $documentData = new DocumentData([]);

        self::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceArgument(): void
    {
        $resourceMock = self::createStub(ResourceInterface::class);

        $documentData = new DocumentData($resourceMock);

        self::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceIdentifierArgument(): void
    {
        $resourceIdentifierMock = self::createStub(ResourceIdentifierInterface::class);

        $documentData = new DocumentData($resourceIdentifierMock);

        self::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceCollectionArgument(): void
    {
        $resourceCollectionMock = self::createStub(ResourceCollectionInterface::class);

        $documentData = new DocumentData($resourceCollectionMock);

        self::assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceIdentifierCollectionArgument(): void
    {
        $resourceIdentifierCollectionMock = self::createStub(ResourceIdentifierCollectionInterface::class);

        $documentData = new DocumentData($resourceIdentifierCollectionMock);

        self::assertInstanceOf(DocumentData::class, $documentData);
    }

    /**
     * @param mixed $invalidArgument
     */
    #[DataProvider('provideItWillThrowExceptionIfConstructedWithInvalidArgumentCases')]
    public function testItWillThrowExceptionIfConstructedWithInvalidArgument($invalidArgument): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new DocumentData($invalidArgument);
    }

    public static function provideItWillThrowExceptionIfConstructedWithInvalidArgumentCases(): iterable
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

    public function testGetResourceWillReturnDataIfDataIsTypeOfResource(): void
    {
        /** @var ResourceInterface $resourceMock */
        $resourceMock = self::createStub(ResourceInterface::class);

        $document = new DocumentData($resourceMock);

        self::assertInstanceOf(ResourceInterface::class, $document->getResource());
    }

    public function testGetResourceCollectionWillReturnDataIfDataIsTypeOfResourceCollection(): void
    {
        /** @var ResourceCollectionInterface $resourceCollectionMock */
        $resourceCollectionMock = self::createStub(ResourceCollectionInterface::class);

        $document = new DocumentData($resourceCollectionMock);

        self::assertInstanceOf(ResourceCollectionInterface::class, $document->getResourceCollection());
    }

    public function testGetResourceWillThrowExceptionIfDataIsNotTypeOfResource(): void
    {
        /** @var ResourceCollectionInterface $resourceCollectionMock */
        $resourceCollectionMock = self::createStub(ResourceCollectionInterface::class);

        $document = new DocumentData($resourceCollectionMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Data is not Resource');

        $document->getResource();
    }

    public function testGetResourceCollectionWillThrowExceptionIfDataIsNotTypeOfResourceCollection(): void
    {
        /** @var ResourceInterface $resourceMock */
        $resourceMock = self::createStub(ResourceInterface::class);

        $document = new DocumentData($resourceMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Data is not Resource Collection');

        $document->getResourceCollection();
    }
}
