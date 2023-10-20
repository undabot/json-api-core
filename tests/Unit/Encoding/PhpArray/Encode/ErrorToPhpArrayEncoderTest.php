<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\SourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Source\SourceInterface;
use Undabot\JsonApi\Implementation\Encoding\ErrorToPhpArrayEncoder;

/**
 * @internal
 *
 * @covers \Undabot\JsonApi\Implementation\Encoding\ErrorToPhpArrayEncoder
 *
 * @small
 */
final class ErrorToPhpArrayEncoderTest extends TestCase
{
    private MockObject $linkEncoderMock;
    private MockObject $sourceEncoderMock;
    private MockObject $metaEncoderMock;
    private ErrorToPhpArrayEncoder $errorEncoder;

    protected function setUp(): void
    {
        $this->linkEncoderMock = $this->createMock(LinkToPhpArrayEncoderInterface::class);
        $this->sourceEncoderMock = $this->createMock(SourceToPhpArrayEncoderInterface::class);
        $this->metaEncoderMock = $this->createMock(MetaToPhpArrayEncoderInterface::class);

        $this->errorEncoder = new ErrorToPhpArrayEncoder(
            $this->linkEncoderMock,
            $this->sourceEncoderMock,
            $this->metaEncoderMock
        );
    }

    public function testItCanBeConstructed(): void
    {
        self::assertInstanceOf(ErrorToPhpArrayEncoder::class, $this->errorEncoder);
        self::assertInstanceOf(ErrorToPhpArrayEncoderInterface::class, $this->errorEncoder);
    }

    public function testEncoderSuccessfullyEncodesPrimitiveValues(): void
    {
        $error = $this->createMock(ErrorInterface::class);
        $error->expects(self::exactly(1))->method('getId')->willReturn('id');
        $error->expects(self::exactly(1))->method('getStatus')->willReturn('status 1');
        $error->expects(self::exactly(1))->method('getCode')->willReturn('code 1');
        $error->expects(self::exactly(1))->method('getTitle')->willReturn('title 1');
        $error->expects(self::exactly(1))->method('getDetail')->willReturn('detail 1');

        $encoded = $this->errorEncoder->encode($error);
        self::assertIsArray($encoded);
        self::assertCount(5, $encoded);
        self::assertSame('id', $encoded['id']);
        self::assertSame('status 1', $encoded['status']);
        self::assertSame('code 1', $encoded['code']);
        self::assertSame('title 1', $encoded['title']);
        self::assertSame('detail 1', $encoded['detail']);
    }

    public function testErrorEncoderWillCallSpecificObjectEncoders(): void
    {
        $error = $this->createMock(ErrorInterface::class);

        $link = $this->createMock(LinkInterface::class);
        $error->expects(self::exactly(1))->method('getAboutLink')->willReturn($link);

        $source = $this->createMock(SourceInterface::class);
        $error->expects(self::exactly(1))->method('getSource')->willReturn($source);

        $meta = $this->createMock(MetaInterface::class);
        $error->expects(self::exactly(1))->method('getMeta')->willReturn($meta);

        $encoded = $this->errorEncoder->encode($error);
        self::assertIsArray($encoded);
        self::assertCount(3, $encoded);
        self::assertArrayHasKey('links', $encoded);
        self::assertArrayHasKey('source', $encoded);
        self::assertArrayHasKey('meta', $encoded);
    }
}
