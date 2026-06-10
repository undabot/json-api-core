<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\ErrorCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;
use Undabot\JsonApi\Implementation\Encoding\ErrorCollectionToPhpArrayEncoder;

/**
 * @internal
 */
#[CoversClass(ErrorCollectionToPhpArrayEncoder::class)]
#[Small]
#[AllowMockObjectsWithoutExpectations]
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
        self::assertInstanceOf(ErrorCollectionToPhpArrayEncoder::class, $this->errorCollectionEncoder);
        self::assertInstanceOf(ErrorCollectionToPhpArrayEncoderInterface::class, $this->errorCollectionEncoder);
    }

    public function testErrorCollectionEncoderWillCallErrorEncoder(): void
    {
        $errorCollection = $this->createMock(ErrorCollectionInterface::class);
        $error1 = self::createStub(ErrorInterface::class);
        $error2 = self::createStub(ErrorInterface::class);
        $error3 = self::createStub(ErrorInterface::class);

        $errors = [
            $error1,
            $error2,
            $error3,
        ];

        $errorCollection->method('getErrors')->willReturn($errors);
        $errorCollection->method('getIterator')->willReturn(new \ArrayIterator($errors));

        $this->errorEncoder->expects(self::exactly(3))->method('encode');

        $encoded = $this->errorCollectionEncoder->encode($errorCollection);
        self::assertIsArray($encoded);
        self::assertCount(3, $encoded);
    }
}
