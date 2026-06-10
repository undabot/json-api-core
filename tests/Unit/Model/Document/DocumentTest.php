<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Model\Document;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
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
 */
#[CoversClass(Document::class)]
#[Small]
final class DocumentTest extends TestCase
{
    public function testItCanBeConstructedWithDocumentDataOnly(): void
    {
        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = self::createStub(DocumentDataInterface::class);

        $document = new Document($documentDataMock);

        self::assertInstanceOf(Document::class, $document);
    }

    public function testItCanBeConstructedWithErrorCollectionOnly(): void
    {
        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = self::createStub(ErrorCollectionInterface::class);

        $document = new Document(null, $errorCollectionMock);

        self::assertInstanceOf(Document::class, $document);
    }

    public function testItCanBeConstructedWithMetaOnly(): void
    {
        /** @var Meta $metaMock */
        $metaMock = self::createStub(MetaInterface::class);

        $document = new Document(null, null, $metaMock);

        self::assertInstanceOf(Document::class, $document);
    }

    public function testItMustContainAtLeastOneOfTheRequiredTopLevelMembers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Document(null);
    }

    public function testExceptionWillBeThrownIfDocumentDataAndErrorsCoexist(): void
    {
        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = self::createStub(DocumentDataInterface::class);

        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = self::createStub(ErrorCollectionInterface::class);

        $this->expectException(\InvalidArgumentException::class);

        new Document($documentDataMock, $errorCollectionMock);
    }

    public function testItWillRecognizeInvalidLinkMember(): void
    {
        $linkCollection = $this->createMock(LinkCollectionInterface::class);

        $invalidLink = $this->createMock(LinkInterface::class);
        $invalidLink->expects(self::exactly(2))
            ->method('getName')
            ->willReturn('invalidLink');

        $linkCollection->expects(self::once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([$invalidLink]));

        /** @var DocumentDataInterface $documentDataMock */
        $documentDataMock = self::createStub(DocumentDataInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        new Document($documentDataMock, null, null, null, $linkCollection);
    }

    public function testItWillRecognizeIncludedWithoutPrimaryDataAsInvalid(): void
    {
        /** @var ResourceCollectionInterface $documentDataMock */
        $included = self::createStub(ResourceCollectionInterface::class);

        /** @var ErrorCollectionInterface $errorCollectionMock */
        $errorCollectionMock = self::createStub(ErrorCollectionInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        new Document(null, $errorCollectionMock, null, null, null, $included);
    }
}
