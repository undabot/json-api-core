<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\DocumentDataToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;
use Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder;

/**
 * @coversDefaultClass \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder
 *
 * @internal
 *
 * @small
 */
final class DocumentDataToPhpArrayEncoderTest extends TestCase
{
    /** @var DocumentDataInterface|MockObject */
    private $documentDataMock;

    /** @var MockObject|ResourceToPhpArrayEncoderInterface */
    private $resourceToPhpArrayEncoderMock;

    /** @var MockObject|ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionToPhpArrayEncoderMock;

    /** @var MockObject|ResourceIdentifierToPhpArrayEncoderInterface */
    private $resourceIdentifierToPhpArrayEncoderMock;

    /** @var MockObject|ResourceIdentifierCollectionToPhpArrayEncoderInterface */
    private $resourceIdentifierCollectionToPhpArrayEncoderMock;

    /** @var DocumentDataToPhpArrayEncoder */
    private $encoder;

    protected function setUp(): void
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

        $this->encoder = new DocumentDataToPhpArrayEncoder(
            $this->resourceToPhpArrayEncoderMock,
            $this->resourceCollectionToPhpArrayEncoderMock,
            $this->resourceIdentifierToPhpArrayEncoderMock,
            $this->resourceIdentifierCollectionToPhpArrayEncoderMock
        );
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder::__construct
     */
    public function testItCanBeConstructed(): void
    {
        static::assertInstanceOf(DocumentDataToPhpArrayEncoderInterface::class, $this->encoder);
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder::encode
     */
    public function testItWillReturnNullIfDocumentDataIsNotValidType(): void
    {
        static::assertNull($this->encoder->encode($this->documentDataMock));
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder::encode
     */
    public function testResourcePhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResource(): void
    {
        $this->resourceToPhpArrayEncoderMock
            ->expects(static::once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResource')
            ->willReturn(true);

        $this->encoder->encode($this->documentDataMock);
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder::encode
     */
    public function testResourceCollectionPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceCollection(): void
    {
        $this->resourceCollectionToPhpArrayEncoderMock
            ->expects(static::once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceCollection')
            ->willReturn(true);

        $this->encoder->encode($this->documentDataMock);
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder::encode
     */
    public function testResourceIdentifierPhpArrayEncoderWillBeUsedIfDocumentDataIsInstanceOfResourceIdentifier(): void
    {
        $this->resourceIdentifierToPhpArrayEncoderMock
            ->expects(static::once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceIdentifier')
            ->willReturn(true);

        $this->encoder->encode($this->documentDataMock);
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentDataToPhpArrayEncoder::encode
     */
    public function testItWillBeUsedIfDocumentDataIsInstanceOfResourceIdentifierCollection(): void
    {
        $this->resourceIdentifierCollectionToPhpArrayEncoderMock
            ->expects(static::once())
            ->method('encode');

        $this->documentDataMock
            ->method('isResourceIdentifierCollection')
            ->willReturn(true);

        $this->encoder->encode($this->documentDataMock);
    }
}
