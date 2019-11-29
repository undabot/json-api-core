<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Model\Document;

use ArrayIterator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Document\Document;
use Undabot\JsonApi\Implementation\Model\Meta\Meta;

class DocumentTest extends TestCase
{
    public function testItCanBeConstructedWithDocumentDataOnly()
    {
        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = $this->createMock(DocumentDataInterface::class);

        $document = new Document($documentDataMock);

        $this->assertInstanceOf(Document::class, $document);
    }

    public function testItCanBeConstructedWithErrorCollectionOnly()
    {
        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = $this->createMock(ErrorCollectionInterface::class);

        $document = new Document(null, $errorCollectionMock);

        $this->assertInstanceOf(Document::class, $document);
    }

    public function testItCanBeConstructedWithMetaOnly()
    {
        /** @var Meta $metaMock */
        $metaMock = $this->createMock(MetaInterface::class);

        $document = new Document(null, null, $metaMock);

        $this->assertInstanceOf(Document::class, $document);
    }

    public function testItMustContainAtLeastOneOfTheRequiredTopLevelMembers()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Document(null);
    }

    public function testExceptionWillBeThrownIfDocumentDataAndErrorsCoexist()
    {
        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = $this->createMock(DocumentDataInterface::class);
        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = $this->createMock(ErrorCollectionInterface::class);

        $this->expectException(\InvalidArgumentException::class);

        new Document($documentDataMock, $errorCollectionMock);
    }

    public function testItWillRecognizeInvalidLinkMember()
    {
        $linkCollection = $this->createMock(LinkCollectionInterface::class);

        $invalidLink = $this->createMock(LinkInterface::class);
        $invalidLink->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('invalidLink');

        $linkCollection->expects($this->once())
            ->method('getIterator')
            ->willReturn(new ArrayIterator([$invalidLink]));

        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = $this->createMock(DocumentDataInterface::class);

        $this->expectException(InvalidArgumentException::class);
        new Document($documentDataMock, null, null, null, $linkCollection);
    }

    public function testItWillRecognizeIncludedWithoutPrimaryDataAsInvalid()
    {
        /** @var ResourceCollectionInterface $documentDataMock */
        $included = $this->createMock(ResourceCollectionInterface::class);

        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = $this->createMock(ErrorCollectionInterface::class);

        $this->expectException(InvalidArgumentException::class);
        new Document(null, $errorCollectionMock, null, null, null, $included);
    }
}
