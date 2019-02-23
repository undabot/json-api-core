<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\ErrorToPhpArrayEncoder;
use Undabot\JsonApi\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\LinkToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\SourceToPhpArrayEncoderInterface;
use Undabot\JsonApi\Model\Error\ErrorInterface;
use Undabot\JsonApi\Model\Link\LinkInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Source\SourceInterface;

class ErrorToPhpArrayEncoderTest extends TestCase
{
    /** @var MockObject|LinkToPhpArrayEncoderInterface */
    private $linkEncoderMock;

    /** @var MockObject|SourceToPhpArrayEncoderInterface */
    private $sourceEncoderMock;

    /** @var MockObject|MetaToPhpArrayEncoderInterface */
    private $metaEncoderMock;

    /** @var ErrorToPhpArrayEncoder */
    private $errorEncoder;

    public function setUp()
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

    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(ErrorToPhpArrayEncoder::class, $this->errorEncoder);
        $this->assertInstanceOf(ErrorToPhpArrayEncoderInterface::class, $this->errorEncoder);
    }

    public function testEncoderSuccessfullyEncodesPrimitiveValues()
    {
        $error = $this->createMock(ErrorInterface::class);
        $error->expects($this->exactly(2))->method('getId')->willReturn('id');
        $error->expects($this->exactly(2))->method('getStatus')->willReturn('status 1');
        $error->expects($this->exactly(2))->method('getCode')->willReturn('code 1');
        $error->expects($this->exactly(2))->method('getTitle')->willReturn('title 1');
        $error->expects($this->exactly(2))->method('getDetail')->willReturn('detail 1');

        $encoded = $this->errorEncoder->encode($error);
        $this->assertIsArray($encoded);
        $this->assertCount(5, $encoded);
        $this->assertSame('id', $encoded['id']);
        $this->assertSame('status 1', $encoded['status']);
        $this->assertSame('code 1', $encoded['code']);
        $this->assertSame('title 1', $encoded['title']);
        $this->assertSame('detail 1', $encoded['detail']);
    }

    public function testErrorEncoderWillCallSpecificObjectEncoders()
    {
        $error = $this->createMock(ErrorInterface::class);

        $link = $this->createMock(LinkInterface::class);
        $error->expects($this->exactly(2))->method('getAboutLink')->willReturn($link);

        $source = $this->createMock(SourceInterface::class);
        $error->expects($this->exactly(2))->method('getSource')->willReturn($source);

        $meta = $this->createMock(MetaInterface::class);
        $error->expects($this->exactly(2))->method('getMeta')->willReturn($meta);

        $encoded = $this->errorEncoder->encode($error);
        $this->assertIsArray($encoded);
        $this->assertCount(3, $encoded);
        $this->assertArrayHasKey('links', $encoded);
        $this->assertArrayHasKey('source', $encoded);
        $this->assertArrayHasKey('meta', $encoded);
    }
}
