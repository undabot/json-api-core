<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Encoding\PhpArray\Encode;

use ArrayIterator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\ErrorCollectionToPhpArrayEncoder;
use Undabot\JsonApi\Encoding\ErrorCollectionToPhpArrayEncoderInterface;
use Undabot\JsonApi\Encoding\ErrorToPhpArrayEncoderInterface;
use Undabot\JsonApi\Model\Document\DocumentDataInterface;
use Undabot\JsonApi\Model\Document\DocumentInterface;
use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Model\Error\ErrorInterface;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;

class ErrorCollectionToPhpArrayEncoderTest extends TestCase
{
    /** @var MockObject|ErrorToPhpArrayEncoderInterface */
    private $errorEncoder;

    /** @var ErrorCollectionToPhpArrayEncoder */
    private $errorCollectionEncoder;

    public function setUp()
    {
        $this->errorEncoder = $this->createMock(ErrorToPhpArrayEncoderInterface::class);
        $this->errorEncoder->method('encode')->will($this->returnValue([]));

        $this->errorCollectionEncoder = new ErrorCollectionToPhpArrayEncoder($this->errorEncoder);
    }

    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(ErrorCollectionToPhpArrayEncoder::class, $this->errorCollectionEncoder);
        $this->assertInstanceOf(ErrorCollectionToPhpArrayEncoderInterface::class, $this->errorCollectionEncoder);
    }

    public function testErrorCollectionEncoderWillCallErrorEncoder()
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

        $this->errorEncoder->expects($this->exactly(3))->method('encode');

        $encoded = $this->errorCollectionEncoder->encode($errorCollection);
        $this->assertIsArray($encoded);
        $this->assertCount(3, $encoded);
    }
}
