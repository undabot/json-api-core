<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\PhpArray\Encode\DocumentDataPhpArrayEncoder;
use Undabot\JsonApi\Encoding\PhpArray\Encode\DocumentDataPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceCollectionPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceIdentifierCollectionPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourceIdentifierPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\PhpArray\Encode\ResourcePhpArrayEncoderInterface;
use Undabot\JsonApi\Model\Document\DocumentDataInterface;

class DocumentDataPhpArrayEncoderTest extends TestCase
{
    /** @var MockObject|DocumentDataInterface */
    private $documentDataMock;
    /** @var MockObject|ResourcePhpArrayEncoderInterface */
    private $resourcePhpArrayEncoderMock;
    /** @var MockObject|ResourceCollectionPhpArrayEncoderInterface */
    private $resourceCollectionPhpArrayEncoderMock;
    /** @var MockObject|ResourceIdentifierPhpArrayEncoderInterface */
    private $resourceIdentifierPhpArrayEncoderMock;
    /** @var MockObject|ResourceIdentifierCollectionPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionPhpArrayEncoderMock;

    public function setUp()
    {
        $this->documentDataMock = $this->createMock(DocumentDataInterface::class);

        $this->resourcePhpArrayEncoderMock = $this->createMock(ResourcePhpArrayEncoderInterface::class);
        $this->resourcePhpArrayEncoderMock->method('encode')->will($this->returnValue([]));

        $this->resourceCollectionPhpArrayEncoderMock = $this->createMock(ResourceCollectionPhpArrayEncoderInterface::class);
        $this->resourceCollectionPhpArrayEncoderMock->method('encode')->will($this->returnValue([]));

        $this->resourceIdentifierPhpArrayEncoderMock = $this->createMock(ResourceIdentifierPhpArrayEncoderInterface::class);
        $this->resourceIdentifierPhpArrayEncoderMock->method('encode')->will($this->returnValue([]));

        $this->resourceIdentifierCollectionPhpArrayEncoderMock = $this->createMock(ResourceIdentifierCollectionPhpArrayEncoderInterface::class);
        $this->resourceIdentifierCollectionPhpArrayEncoderMock->method('encode')->will($this->returnValue([]));
    }

    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(DocumentDataPhpArrayEncoderInterface::class, $this->getEncoder());
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

    private function getEncoder(): DocumentDataPhpArrayEncoderInterface
    {
        return new DocumentDataPhpArrayEncoder(
            $this->resourcePhpArrayEncoderMock,
            $this->resourceCollectionPhpArrayEncoderMock,
            $this->resourceIdentifierPhpArrayEncoderMock,
            $this->resourceIdentifierCollectionPhpArrayEncoderMock
        );
    }
}
