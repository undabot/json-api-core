<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use ArrayIterator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\ErrorCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;
use Undabot\JsonApi\Implementation\Encoding\ErrorCollectionToPhpArrayEncoder;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Encoding\ErrorCollectionToPhpArrayEncoder
 *
 * @small
 */
final class ErrorCollectionToPhpArrayEncoderTest extends TestCase
{
    private MockObject $errorEncoder;
    private ErrorCollectionToPhpArrayEncoder $errorCollectionEncoder;

    protected function setUp(): void
    {
        $this->errorEncoder = $this->createMock(ErrorToPhpArrayEncoderInterface::class);
        $this->errorEncoder->method('encode')->willReturn([]);

        $this->errorCollectionEncoder = new ErrorCollectionToPhpArrayEncoder($this->errorEncoder);
    }

    public function testItCanBeConstructed(): void
    {
        static::assertInstanceOf(ErrorCollectionToPhpArrayEncoder::class, $this->errorCollectionEncoder);
        static::assertInstanceOf(ErrorCollectionToPhpArrayEncoderInterface::class, $this->errorCollectionEncoder);
    }

    public function testErrorCollectionEncoderWillCallErrorEncoder(): void
    {
        $errorCollection = $this->createMock(ErrorCollectionInterface::class);
        $error1 = $this->createMock(ErrorInterface::class);
        $error2 = $this->createMock(ErrorInterface::class);
        $error3 = $this->createMock(ErrorInterface::class);

        $errors = [
            $error1,
            $error2,
            $error3,
        ];

        $errorCollection->method('getErrors')->willReturn($errors);
        $errorCollection->method('getIterator')->willReturn(new ArrayIterator($errors));

        $this->errorEncoder->expects(static::exactly(3))->method('encode');

        $encoded = $this->errorCollectionEncoder->encode($errorCollection);
        static::assertIsArray($encoded);
        static::assertCount(3, $encoded);
    }
}
