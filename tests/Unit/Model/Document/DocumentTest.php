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

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Model\Document\Document
 *
 * @small
 */
final class DocumentTest extends TestCase
{
    public function testItCanBeConstructedWithDocumentDataOnly(): void
    {
        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = $this->createMock(DocumentDataInterface::class);

        $document = new Document($documentDataMock);

        static::assertInstanceOf(Document::class, $document);
    }

    public function testItCanBeConstructedWithErrorCollectionOnly(): void
    {
        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = $this->createMock(ErrorCollectionInterface::class);

        $document = new Document(null, $errorCollectionMock);

        static::assertInstanceOf(Document::class, $document);
    }

    public function testItCanBeConstructedWithMetaOnly(): void
    {
        /** @var Meta $metaMock */
        $metaMock = $this->createMock(MetaInterface::class);

        $document = new Document(null, null, $metaMock);

        static::assertInstanceOf(Document::class, $document);
    }

    public function testItMustContainAtLeastOneOfTheRequiredTopLevelMembers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Document(null);
    }

    public function testExceptionWillBeThrownIfDocumentDataAndErrorsCoexist(): void
    {
        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = $this->createMock(DocumentDataInterface::class);
        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = $this->createMock(ErrorCollectionInterface::class);

        $this->expectException(\InvalidArgumentException::class);

        new Document($documentDataMock, $errorCollectionMock);
    }

    public function testItWillRecognizeInvalidLinkMember(): void
    {
        $linkCollection = $this->createMock(LinkCollectionInterface::class);

        $invalidLink = $this->createMock(LinkInterface::class);
        $invalidLink->expects(static::exactly(2))
            ->method('getName')
            ->willReturn('invalidLink');

        $linkCollection->expects(static::once())
            ->method('getIterator')
            ->willReturn(new ArrayIterator([$invalidLink]));

        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = $this->createMock(DocumentDataInterface::class);

        $this->expectException(InvalidArgumentException::class);
        new Document($documentDataMock, null, null, null, $linkCollection);
    }

    public function testItWillRecognizeIncludedWithoutPrimaryDataAsInvalid(): void
    {
        /** @var ResourceCollectionInterface $documentDataMock */
        $included = $this->createMock(ResourceCollectionInterface::class);

        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = $this->createMock(ErrorCollectionInterface::class);

        $this->expectException(InvalidArgumentException::class);
        new Document(null, $errorCollectionMock, null, null, null, $included);
    }
}
