<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Model\Document;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Model\Document\DocumentData;
use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierCollectionInterface;
use Undabot\JsonApi\Model\Resource\ResourceIdentifierInterface;
use Undabot\JsonApi\Model\Resource\ResourceInterface;

class DocumentDataTest extends TestCase
{
    public function testItCanBeConstructedWithNullArgument()
    {
        $documentData = new DocumentData(null);

        $this->assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithEmptyArrayArgument()
    {
        $documentData = new DocumentData([]);

        $this->assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceArgument()
    {
        $resourceMock = $this->createMock(ResourceInterface::class);

        $documentData = new DocumentData($resourceMock);

        $this->assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceIdentifierArgument()
    {
        $resourceIdentifierMock = $this->createMock(ResourceIdentifierInterface::class);

        $documentData = new DocumentData($resourceIdentifierMock);

        $this->assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceCollectionArgument()
    {
        $resourceCollectionMock = $this->createMock(ResourceCollectionInterface::class);

        $documentData = new DocumentData($resourceCollectionMock);

        $this->assertInstanceOf(DocumentData::class, $documentData);
    }

    public function testItCanBeConstructedWithResourceIdentifierCollectionArgument()
    {
        $resourceIdentifierCollectionMock = $this->createMock(ResourceIdentifierCollectionInterface::class);

        $documentData = new DocumentData($resourceIdentifierCollectionMock);

        $this->assertInstanceOf(DocumentData::class, $documentData);
    }

    /**
     * @dataProvider provideInvalidConstructorArguments
     */
    public function testItWillThrowExceptionIfConstructedWithInvalidArgument($invalidArgument)
    {
        $this->expectException(\InvalidArgumentException::class);

        new DocumentData($invalidArgument);
    }

    public function testGetResourceWillReturnDataIfDataIsTypeOfResource()
    {
        /** @var ResourceInterface $resourceMock */
        $resourceMock = $this->createMock(ResourceInterface::class);

        $document = new DocumentData($resourceMock);

        $this->assertInstanceOf(ResourceInterface::class, $document->getResource());
    }

    public function testGetResourceCollectionWillReturnDataIfDataIsTypeOfResourceCollection()
    {
        /** @var ResourceCollectionInterface $resourceCollectionMock */
        $resourceCollectionMock = $this->createMock(ResourceCollectionInterface::class);

        $document = new DocumentData($resourceCollectionMock);

        $this->assertInstanceOf(ResourceCollectionInterface::class, $document->getResourceCollection());
    }

    public function testGetResourceWillThrowExceptionIfDataIsNotTypeOfResource()
    {
        /** @var ResourceCollectionInterface $resourceCollectionMock */
        $resourceCollectionMock = $this->createMock(ResourceCollectionInterface::class);

        $document = new DocumentData($resourceCollectionMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Data is not Resource');

        $document->getResource();
    }

    public function testGetResourceCollectionWillThrowExceptionIfDataIsNotTypeOfResourceCollection()
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
