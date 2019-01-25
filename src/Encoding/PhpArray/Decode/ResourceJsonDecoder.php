<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding\PhpArray\Decode;

use Undabot\JsonApi\Encoding\PhpArray\Exception\PhpArrayDecodingException;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\Resource;
use Undabot\JsonApi\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Util\Assert\Assert;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;

class ResourceJsonDecoder implements ResourceJsonDecoderInterface
{
    /** @var RelationshipCollectionJsonDecoderInterface */
    private $relationshipCollectionDecoder;

    /** @var AttributeCollectionJsonDecoderInterface */
    private $attributeCollectionDecoder;

    /** @var LinkCollectionJsonDecoderInterface */
    private $linkCollectionDecoder;

    /** @var MetaJsonDecoderInterface */
    private $metaDecoder;

    public function __construct(
        RelationshipCollectionJsonDecoderInterface $relationshipCollectionDecoder,
        AttributeCollectionJsonDecoderInterface $attributeCollectionDecoder,
        LinkCollectionJsonDecoderInterface $linkCollectionDecoder,
        MetaJsonDecoderInterface $metaDecoder
    ) {
        $this->relationshipCollectionDecoder = $relationshipCollectionDecoder;
        $this->attributeCollectionDecoder = $attributeCollectionDecoder;
        $this->linkCollectionDecoder = $linkCollectionDecoder;
        $this->metaDecoder = $metaDecoder;
    }

    private function throwException(string $message): void
    {
        throw new PhpArrayDecodingException($message);
    }

    /**
     * @throws PhpArrayDecodingException
     */
    public function decode(array $resource): ResourceInterface
    {
        try {
            $resourceValidationResult = Assert::validJsonResource($resource);
            if (false === $resourceValidationResult) {
                $this->throwException('Non valid JSON:API resource given');
            }
        } catch (AssertException $exception) {
            $this->throwException($exception->getMessage());
        }

        $rawRelationships = $resource['relationships'] ?? [];
        $rawAttributes = $resource['attributes'] ?? [];
        $rawMeta = $resource['meta'] ?? null;
        $rawLinks = $resource['links'] ?? null;

        return new Resource(
            $resource['id'],
            $resource['type'],
            $this->attributeCollectionDecoder->decode($rawAttributes),
            $this->relationshipCollectionDecoder->decode($rawRelationships),
            null, // @todo parse self link
            $this->parseMeta($rawMeta)
        );
    }

    private function parseLinks(?array $rawLinks): ?LinkCollectionInterface
    {
        if (null === $rawLinks) {
            return null;
        }

        return $this->linkCollectionDecoder->decode($rawLinks);
    }

    private function parseMeta(?array $rawMeta): ?MetaInterface
    {
        if (null === $rawMeta) {
            return null;
        }

        return $this->metaDecoder->decode($rawMeta);
    }
}
