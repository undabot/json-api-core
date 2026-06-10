<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Unit\Link;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Model\Link\LinkMemberInterface;
use Undabot\JsonApi\Implementation\Model\Link\Link;

/**
 * @internal
 */
#[CoversClass(Link::class)]
#[Small]
final class LinkTest extends TestCase
{
    private Stub $linkUrlMock;

    protected function setUp(): void
    {
        $this->linkUrlMock = self::createStub(LinkMemberInterface::class);
    }

    #[DataProvider('provideLinkCanBeConstructedWithValidNameOnlyCases')]
    public function testLinkCanBeConstructedWithValidNameOnly(string $validLinkName): void
    {
        $validLink = new Link($validLinkName, $this->linkUrlMock);

        self::assertInstanceOf(Link::class, $validLink);
    }

    public static function provideLinkCanBeConstructedWithValidNameOnlyCases(): iterable
    {
        return [
            ['self'],
            ['related'],
        ];
    }

    #[DataProvider('provideLinkCannotBeConstructedWithInvalidNameCases')]
    public function testLinkCannotBeConstructedWithInvalidName(string $invalidLinkName): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Link($invalidLinkName, $this->linkUrlMock);
    }

    public static function provideLinkCannotBeConstructedWithInvalidNameCases(): iterable
    {
        return [
            ['invalid'],
        ];
    }
}
