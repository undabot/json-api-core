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
 */
class DocumentToPhpArrayEncoderTest extends TestCase
{
    /** @var MockObject|DocumentDataToPhpArrayEncoderInterface */
    private $documentDataEncoderMock;

    /** @var MockObject|ResourceCollectionToPhpArrayEncoderInterface */
    private $resourceCollectionToPhpArrayEncoderMock;

    /** @var MockObject|ErrorCollectionToPhpArrayEncoderInterface */
    private $errorCollectionEncoderMock;

    /** @var MockObject|MetaToPhpArrayEncoderInterface */
    private $metaEncoderMock;

    /** @var MockObject|LinkCollectionToPhpArrayEncoderInterface */
    private $linkCollectionEncoderMock;

    /** @var DocumentToPhpArrayEncoder */
    private $documentEncoder;

    public function setUp(): void
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
    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(DocumentToPhpArrayEncoder::class, $this->documentEncoder);
        $this->assertInstanceOf(DocumentToPhpArrayEncoderInterface::class, $this->documentEncoder);
    }

    /**
     * @covers \Undabot\JsonApi\Implementation\Encoding\DocumentToPhpArrayEncoder::encode
     */
    public function testEncoderWillCallRespectiveSpecificEncoders()
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

        $this->documentDataEncoderMock->expects($this->once())->method('encode');
        $this->errorCollectionEncoderMock->expects($this->once())->method('encode');
        $this->metaEncoderMock->expects($this->exactly(2))->method('encode');

        $encoded = $this->documentEncoder->encode($document);
        $this->assertIsArray($encoded);
        $this->assertArrayHasKey('data', $encoded);
        $this->assertArrayHasKey('errors', $encoded);
        $this->assertArrayHasKey('meta', $encoded);
        $this->assertArrayHasKey('jsonapi', $encoded);
        $this->assertArrayHasKey('links', $encoded);
    }
}
