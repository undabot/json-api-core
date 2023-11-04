<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Link;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;
use Undabot\JsonApi\Implementation\Model\Link\Link;

/**
 * @internal
 *
 * @covers \Undabot\JsonApi\Implementation\Model\Link\Link
 *
 * @small
 */
final class LinkTest extends TestCase
{
    private MockObject $linkUrlMock;

    protected function setUp(): void
    {
        $this->linkUrlMock = $this->createMock(LinkMemberInterface::class);
    }

    /**
     * @dataProvider provideLinkCanBeConstructedWithValidNameOnlyCases
     */
    public function testLinkCanBeConstructedWithValidNameOnly(string $validLinkName): void
    {
        $validLink = new Link($validLinkName, $this->linkUrlMock);

        self::assertInstanceOf(Link::class, $validLink);
    }

    /**
     * @dataProvider provideLinkCannotBeConstructedWithInvalidNameCases
     */
    public function testLinkCannotBeConstructedWithInvalidName(string $invalidLinkName): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Link($invalidLinkName, $this->linkUrlMock);
    }

    public function provideLinkCanBeConstructedWithValidNameOnlyCases(): iterable
    {
        return [
            ['self'],
            ['related'],
        ];
    }

    public function provideLinkCannotBeConstructedWithInvalidNameCases(): iterable
    {
        return [
            ['invalid'],
        ];
    }
}
