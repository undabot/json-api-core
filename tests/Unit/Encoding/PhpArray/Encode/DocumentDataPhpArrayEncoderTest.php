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

class DocumentDataPhpArrayEncoderTest extends TestCase
{
    /** @var MockObject|DocumentDataInterface */
    private $documentDataMock;
    /** @var MockObject|ResourceToPhpArrayEncoderInterface */
    private $resourcePhpArrayEncoderMock;
    /** @var MockObject|ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionPhpArrayEncoderMock;
    /** @var MockObject|ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierPhpArrayEncoderMock;
    /** @var MockObject|ResourceIdentifierCollectionToPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionPhpArrayEncoderMock;

    public function setUp()
    {
        $this->documentDataMock = $this->createMock(DocumentDataInterface::class);

        $this->resourcePhpArrayEncoderMock = $this->createMock(ResourceToPhpArrayEncoderInterface::class);
        $this->resourcePhpArrayEncoderMock->method('encode')->will($this->returnValue([]));

        $this->resourceCollectionPhpArrayEncoderMock = $this->createMock(ResourceCollectionToPhpArrayEncoderInterface::class);
        $this->resourceCollectionPhpArrayEncoderMock->method('encode')->will($this->returnValue([]));

        $this->resourceIdentifierPhpArrayEncoderMock = $this->createMock(ResourceIdentifierToPhpArrayEncoderInterface::class);
        $this->resourceIdentifierPhpArrayEncoderMock->method('encode')->will($this->returnValue([]));

        $this->resourceIdentifierCollectionPhpArrayEncoderMock = $this->createMock(ResourceIdentifierCollectionToPhpArrayEncoderInterface::class);
        $this->resourceIdentifierCollectionPhpArrayEncoderMock->method('encode')->will($this->returnValue([]));
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
        $this->resourcePhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResource')
            ->will($this->returnValue(true));

        $this->getEncoder()->encode($this->documentDataMock);
    }

    public function testResourceCollectionPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceCollection()
    {
        $this->resourceCollectionPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceCollection')
            ->will($this->returnValue(true));

        $this->getEncoder()->encode($this->documentDataMock);
    }

    public function testResourceIdentifierPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceIdentifier()
    {
        $this->resourceIdentifierPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceIdentifier')
            ->will($this->returnValue(true));

        $this->getEncoder()->encode($this->documentDataMock);
    }

    public function testResourceIdentifierCollectionPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceIdentifierCollection()
    {
        $this->resourceIdentifierCollectionPhpArrayEncoderMock
            ->expects($this->once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceIdentifierCollection')
            ->will($this->returnValue(true));

        $this->getEncoder()->encode($this->documentDataMock);
    }

    private function getEncoder(): DocumentDataToPhpArrayEncoderInterface
    {
        return new DocumentDataToPhpArrayEncoder(
            $this->resourcePhpArrayEncoderMock,
            $this->resourceCollectionPhpArrayEncoderMock,
            $this->resourceIdentifierPhpArrayEncoderMock,
            $this->resourceIdentifierCollectionPhpArrayEncoderMock
        );
    }
}
