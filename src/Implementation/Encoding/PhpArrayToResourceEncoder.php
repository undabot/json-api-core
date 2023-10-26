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


        $rawAttributes = $this->assertStringKeyArray($resource, 'attributes');
        $rawMeta = $this->assertStringKeyArray($resource, 'meta');
        $rawLink = is_array($resource['links'] ?? null) ? ($resource['links']['self'] ?? null) : null;
        $rawRelationships = $this->assertStringKeyArrayNested($resource, 'relationships');

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

//    /**
//     *
//     * @param mixed $array
//     * @return array<string, mixed>
//     */
//    private function assertStringKeyArray(mixed $array): array
//    {
//        if (!is_array($array)) {
//            throw new \InvalidArgumentException("Parameter is not array.");
//        }
//        foreach ($array as $key) {
//            if (!is_string($key)) {
//                throw new \InvalidArgumentException("Array key must be a string.");
//            }
//        }
//
//        return $array;
//
//    }

    /**
     * Asserts and returns an array with string keys. If the key does not exist in the source array,
     * it returns an empty array or a specified default value.
     *
     * @param array<mixed> $source The source array from which to extract the value.
     * @param string $key The key to look for in the source array.
     * @param mixed $default The default value to return if the key is not found. Defaults to an empty array.
     * @return array<string, mixed> The asserted array with string keys and mixed values.
     */
    private function assertStringKeyArray(array $source, string $key, $default = []): array
    {
        $array = $source[$key] ?? $default;

        if (!is_array($array)) {
            throw new \InvalidArgumentException("The value for '{$key}' is not an array.");
        }

        foreach (array_keys($array) as $key) {
            if (!is_string($key)) {
                throw new \InvalidArgumentException("Array key must be a string.");
            }
        }

        return $array;
    }

    /**
     * Asserts and returns a nested array with string keys. If the key does not exist in the source array,
     * it returns an empty array or a specified default value.
     *
     * @param array<mixed> $source The source array from which to extract the value.
     * @param string $key The key to look for in the source array.
     * @param mixed $default The default value to return if the key is not found. Defaults to an empty array.
     * @return array<string, array<string, mixed>> The asserted nested array with string keys at both levels.
     */
    private function assertStringKeyArrayNested(array $source, string $key, $default = []): array
    {
        $array = $source[$key] ?? $default;

        if (!is_array($array)) {
            throw new \InvalidArgumentException("The value for '{$key}' is not an array.");
        }

        foreach ($array as $topKey => $nestedArray) {
            if (!is_string($topKey)) {
                throw new \InvalidArgumentException("Top-level key must be a string.");
            }

            if (!is_array($nestedArray)) {
                throw new \InvalidArgumentException("Value under '{$topKey}' must be an array.");
            }

            $array[$topKey] = $this->assertStringKeyArray($nestedArray, $key);
        }

        return $array;
    }
}
