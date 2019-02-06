<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Tests\Integration\Encoding;

use PHPUnit\Framework\TestCase;
use Undabot\JsonApi\Encoding\MetaToPhpArrayEncoder;
use Undabot\JsonApi\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Model\Meta\JsonApiMeta;
use Undabot\JsonApi\Model\Meta\Meta;

class MetaSerializerTest extends TestCase
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $serializer;

    protected function setUp()
    {
        $this->serializer = new MetaToPhpArrayEncoder();
    }

    public function testMetaObjectIsSerializedCorrectly()
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
        $expectedJson = <<<JSON
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

        $this->assertEquals($expectedJson, $serializedJson);
    }

    public function testJsonApiObjectIsSerializedCorrectly()
    {
        $meta = new JsonApiMeta([
            'version' => '1.0',
        ]);

        $serialized = $this->serializer->encode($meta);
        $serializedJson = json_encode($serialized, JSON_PRETTY_PRINT);
        $expectedJson = <<<JSON
{
    "version": "1.0"
}
JSON;

        $this->assertEquals($expectedJson, $serializedJson);
    }
}
