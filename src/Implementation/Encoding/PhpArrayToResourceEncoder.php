<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToAttributeCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToRelationshipCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToResourceEncoderInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\JsonApiEncodingException;
use Undabot\JsonApi\Implementation\Model\Resource\Resource;
use Undabot\JsonApi\Util\Exception\ValidationException;
use Undabot\JsonApi\Util\ValidResourceAssertion;

/** @psalm-api */
class PhpArrayToResourceEncoder implements PhpArrayToResourceEncoderInterface
{
    /** @var PhpArrayToRelationshipCollectionEncoderInterface */
    private $phpArrayToRelationshipCollectionEncoder;

    /** @var PhpArrayToAttributeCollectionEncoderInterface */
    private $phpArrayToAttributeCollectionEncoder;

    /** @var PhpArrayToMetaEncoderInterface */
    private $phpArrayToMetaEncoder;

    public function __construct(
        PhpArrayToRelationshipCollectionEncoderInterface $phpArrayToRelationshipCollectionEncoder,
        PhpArrayToAttributeCollectionEncoderInterface    $phpArrayToAttributeCollectionEncoder,
        PhpArrayToMetaEncoderInterface                   $phpArrayToMetaEncoder
    )
    {
        $this->phpArrayToRelationshipCollectionEncoder = $phpArrayToRelationshipCollectionEncoder;
        $this->phpArrayToAttributeCollectionEncoder = $phpArrayToAttributeCollectionEncoder;
        $this->phpArrayToMetaEncoder = $phpArrayToMetaEncoder;
    }

    /**
     * @throws JsonApiEncodingException
     */
    public function decode(array $resource): ResourceInterface
    {
        try {
            ValidResourceAssertion::assert($resource);
        } catch (ValidationException $exception) {
            throw new JsonApiEncodingException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }


        $rawAttributes = $this->assertStringKeyArray($resource['attributes'] ?? []);
        $rawMeta = $this->assertStringKeyArray($resource['meta'] ?? null);
        $rawLink = is_array($resource['links'] ?? null) ? ($resource['links']['self'] ?? null) : null;
        $rawRelationships = $this->assertStringKeyArrayNested($resource['relationships'] ?? []);

        if (null !== $rawLink) {
            throw new \RuntimeException('Not implemented');
        }

        $id = is_string($resource['id']) ? $resource['id'] : throw new \InvalidArgumentException("Expected a string for 'id'");
        $type = is_string($resource['type']) ? $resource['type'] : throw new \InvalidArgumentException("Expected a string for 'type'");

        return new Resource(
            $id,
            $type,
            $this->phpArrayToAttributeCollectionEncoder->encode($rawAttributes),
            $this->phpArrayToRelationshipCollectionEncoder->encode($rawRelationships),
            null,
            $this->parseMeta($rawMeta)
        );
    }

    /**
     * @param null|array<string, mixed> $rawMeta
     */
    private function parseMeta(?array $rawMeta): ?MetaInterface
    {
        if (null === $rawMeta) {
            return null;
        }

        return $this->phpArrayToMetaEncoder->decode($rawMeta);
    }

    /**
     *
     * @param mixed $array
     * @return array<string, mixed>
     */
    private function assertStringKeyArray(mixed $array): array
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException("Parameter is not array.");
        }
        foreach ($array as $key) {
            if (!is_string($key)) {
                throw new \InvalidArgumentException("Array key must be a string.");
            }
        }

        return $array;

    }

    /**
     *
     * @param mixed $array
     * @return array<string, array<string, mixed>>
     */
    function assertStringKeyArrayNested(mixed $array): array
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException("Parameter is not array.");
        }
        foreach ($array as $key => $value) {
            if (!is_string($key)) {
                throw new \InvalidArgumentException("Top-level key must be a string.");
            }
            if (!is_array($value)) {
                throw new \InvalidArgumentException("Each relationship must be an array.");
            }
            $array[$key] = $this->assertStringKeyArray($value);
        }

        return $array;
    }

}
