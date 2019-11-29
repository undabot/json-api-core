<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Link;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;
use Undabot\JsonApi\Implementation\Model\Link\Link;

class LinkTest extends TestCase
{
    /** @var LinkMemberInterface|MockObject */
    private $linkUrlMock;

    public function setUp()
    {
        $this->linkUrlMock = $this->createMock(LinkMemberInterface::class);
    }

    /**
     * @dataProvider validLinkNames
     */
    public function testLinkCanBeConstructedWithValidNameOnly(string $validLinkName): void
    {
        $validLink = new Link($validLinkName, $this->linkUrlMock);

        $this->assertInstanceOf(Link::class, $validLink);
    }

    /**
     * @dataProvider invalidLinkNames
     */
    public function testLinkCannotBeConstructedWithInvalidName(string $invalidLinkName): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Link($invalidLinkName, $this->linkUrlMock);
    }

    public function validLinkNames(): array
    {
        return [
            ['self'],
            ['related'],
        ];
    }

    public function invalidLinkNames(): array
    {
        return [
            ['invalid'],
        ];
    }
}
