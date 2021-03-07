<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Integration\Encoding;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Implementation\Encoding\MetaToPhpArrayEncoder;
use Undabot\JsonApi\Implementation\Model\Meta\JsonApiMeta;
use Undabot\JsonApi\Implementation\Model\Meta\Meta;

/**
 * @internal
 * @covers \Undabot\JsonApi\Implementation\Encoding\MetaToPhpArrayEncoder
 *
 * @small
 */
final class MetaSerializerTest extends TestCase
{
    private MetaToPhpArrayEncoderInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = new MetaToPhpArrayEncoder();
    }

    public function testMetaObjectIsSerializedCorrectly(): void
    {
        $meta = new Meta([
            'copyright' => 'Copyright 2015 Example Corp.',
            'authors' => [
                'Yehuda Katz',
                'Steve Klabnik',
                'Dan Gebhardt',
                'Tyler Kellen',
            ],
        ]);

        $serialized = $this->serializer->encode($meta);
        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT);
        $expectedJson = <<<'JSON'
            {
                "copyright": "Copyright 2015 Example Corp.",
                "authors": [
                    "Yehuda Katz",
                    "Steve Klabnik",
                    "Dan Gebhardt",
                    "Tyler Kellen"
                ]
            }
            JSON;

        static::assertEquals($expectedJson, $serializedJson);
    }

    public function testJsonApiObjectIsSerializedCorrectly(): void
    {
        $meta = new JsonApiMeta([
            'version' => '1.0',
        ]);

        $serialized = $this->serializer->encode($meta);
        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT);
        $expectedJson = <<<'JSON'
            {
                "version": "1.0"
            }
            JSON;

        static::assertEquals($expectedJson, $serializedJson);
    }
}
