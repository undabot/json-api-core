<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\DocumentDataToPhpArrayEncoder;
use Undabot\JsonApi\Encoding\DocumentDataToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\ResourceIdentifierCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\ResourceIdentifierToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Model\Document\DocumentDataInterface;

class DocumentDataToPhpArrayEncoderTest extends TestCase
{
    /** @var MockObject|DocumentDataInterface */
    private $documentDataMock;
    /** @var MockObject|ResourceToPhpArrayEncoderInterface */
    private $resourceToPhpArrayEncoderMock;
    /** @var MockObject|ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionToPhpArrayEncoderMock;
    /** @var MockObject|ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierToPhpArrayEncoderMock;
    /** @var MockObject|ResourceIdentifierCollectionToPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionToPhpArrayEncoderMock;

    public function setUp()
    {
        $this->documentDataMock = $this->createMock(DocumentDataInterface::class);

        $this->resourceToPhpArrayEncoderMock = $this->createMock(ResourceToPhpArrayEncoderInterface::class);
        $this->resourceToPhpArrayEncoderMock->method('encode')->willReturn([]);

        $this->resourceCollectionToPhpArrayEncoderMock = $this->createMock(ResourceCollectionToPhpArrayEncoderInterface::class);
        $this->resourceCollectionToPhpArrayEncoderMock->method('encode')->willReturn([]);

        $this->resourceIdentifierToPhpArrayEncoderMock = $this->createMock(ResourceIdentifierToPhpArrayEncoderInterface::class);
        $this->resourceIdentifierToPhpArrayEncoderMock->method('encode')->willReturn([]);

        $this->resourceIdentifierCollectionToPhpArrayEncoderMock = $this->createMock(ResourceIdentifierCollectionToPhpArrayEncoderInterface::class);
        $this->resourceIdentifierCollectionToPhpArrayEncoderMock->method('encode')->willReturn([]);
    }

    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(DocumentDataToPhpArrayEncoderInterface::class, $this->getEncoder());
    }

    public function testItWillReturnNullIfDocumentDataIsNotValidType()
    {
        $this->assertNull($this->getEncoder()->encode($this->documentDataMock));
    }

    public function testResourcePhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResource()
    {
        $this->resourceToPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResource')
            ->willReturn(true);

        $this->getEncoder()->encode($this->documentDataMock);
    }

    public function testResourceCollectionPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceCollection()
    {
        $this->resourceCollectionToPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceCollection')
            ->willReturn(true);

        $this->getEncoder()->encode($this->documentDataMock);
    }

    public function testResourceIdentifierPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceIdentifier()
    {
        $this->resourceIdentifierToPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceIdentifier')
            ->willReturn(true);

        $this->getEncoder()->encode($this->documentDataMock);
    }

    public function testResourceIdentifierCollectionPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceIdentifierCollection()
    {
        $this->resourceIdentifierCollectionToPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceIdentifierCollection')
            ->willReturn(true);

        $this->getEncoder()->encode($this->documentDataMock);
    }

    private function getEncoder(): DocumentDataToPhpArrayEncoderInterface
    {
        return new DocumentDataToPhpArrayEncoder(
            $this->resourceToPhpArrayEncoderMock,
            $this->resourceCollectionToPhpArrayEncoderMock,
            $this->resourceIdentifierToPhpArrayEncoderMock,
            $this->resourceIdentifierCollectionToPhpArrayEncoderMock
        );
    }
}
