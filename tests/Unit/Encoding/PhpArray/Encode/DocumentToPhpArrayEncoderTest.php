<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\DocumentDataToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\DocumentToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ErrorCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;
use Undabot\JsonApi\Definition\Model\Document\DocumentInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder;

/**
 * @coversDefaultClass \Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder
 *
 * @internal
 *
 * @small
 */
final class DocumentToPhpArrayEncoderTest extends TestCase
{
    /** @var DocumentDataToPhpArrayEncoderInterface|MockObject */
    private $documentDataEncoderMock;

    /** @var MockObject|ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionToPhpArrayEncoderMock;

    /** @var ErrorCollectionToPhpArrayEncoderInterface|MockObject */
    private $errorCollectionEncoderMock;

    /** @var MetaToPhpArrayEncoderInterface|MockObject */
    private $metaEncoderMock;

    /** @var LinkCollectionToPhpArrayEncoderInterface|MockObject */
    private $linkCollectionEncoderMock;

    /** @var DocumentToPhpArrayEncoder */
    private $documentEncoder;

    protected function setUp(): void
    {
        $this->documentDataEncoderMock = $this->createMock(DocumentDataToPhpArrayEncoderInterface::class);
        $this->documentDataEncoderMock->method('encode')->willReturn([]);

        $this->resourceCollectionToPhpArrayEncoderMock = $this->createMock(ResourceCollectionToPhpArrayEncoderInterface::class);
        $this->resourceCollectionToPhpArrayEncoderMock->method('encode')->willReturn([]);

        $this->errorCollectionEncoderMock = $this->createMock(ErrorCollectionToPhpArrayEncoderInterface::class);
        $this->errorCollectionEncoderMock->method('encode')->willReturn([]);

        $this->linkCollectionEncoderMock = $this->createMock(LinkCollectionToPhpArrayEncoderInterface::class);
        $this->linkCollectionEncoderMock->method('encode')->willReturn([]);

        $this->metaEncoderMock = $this->createMock(MetaToPhpArrayEncoderInterface::class);
        $this->metaEncoderMock->method('encode')->willReturn([]);

        $this->documentEncoder = new DocumentToPhpArrayEncoder(
            $this->documentDataEncoderMock,
            $this->errorCollectionEncoderMock,
            $this->metaEncoderMock,
            $this->linkCollectionEncoderMock,
            $this->resourceCollectionToPhpArrayEncoderMock
        );
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder::__construct
     */
    public function testItCanBeConstructed(): void
    {
        self::assertInstanceOf(DocumentToPhpArrayEncoder::class, $this->documentEncoder);
        self::assertInstanceOf(DocumentToPhpArrayEncoderInterface::class, $this->documentEncoder);
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder::encode
     */
    public function testEncoderWillCallRespectiveSpecificEncoders(): void
    {
        $documentData = $this->createMock(DocumentDataInterface::class);
        $errors = $this->createMock(ErrorCollectionInterface::class);
        $meta = $this->createMock(MetaInterface::class);
        $jsonApiMeta = $this->createMock(MetaInterface::class);
        $links = $this->createMock(LinkCollectionInterface::class);
        $document = $this->createMock(DocumentInterface::class);

        $document->method('getData')->willReturn($documentData);
        $document->method('getErrors')->willReturn($errors);
        $document->method('getMeta')->willReturn($meta);
        $document->method('getJsonApiMeta')->willReturn($jsonApiMeta);
        $document->method('getLinks')->willReturn($links);

        $this->documentDataEncoderMock->expects(self::once())->method('encode');
        $this->errorCollectionEncoderMock->expects(self::once())->method('encode');
        $this->metaEncoderMock->expects(self::exactly(2))->method('encode');

        $encoded = $this->documentEncoder->encode($document);
        self::assertIsArray($encoded);
        self::assertArrayHasKey('data', $encoded);
        self::assertArrayHasKey('errors', $encoded);
        self::assertArrayHasKey('meta', $encoded);
        self::assertArrayHasKey('jsonapi', $encoded);
        self::assertArrayHasKey('links', $encoded);
    }
}
