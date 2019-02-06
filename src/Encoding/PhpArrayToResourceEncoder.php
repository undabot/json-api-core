<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Encoding;

use Undabot\JsonApi\Encoding\Exception\PhpArrayDecodingException;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\Resource;
use Undabot\JsonApi\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Util\Assert\Assert;
use Undabot\JsonApi\Util\Assert\Exception\AssertException;

class PhpArrayToResourceEncoder implements PhpArrayToResourceEncoderInterface
{
    /** @var PhpArrayToRelationshipCollectionEncoderInterface */
    private $phpArrayToRelationshipCollectionEncoder;

    /** @var PhpArrayToAttributeCollectionEncoderInterface */
    private $phpArrayToAttributeCollectionEncoder;

    /** @var PhpArrayToLinkCollectionEncoderInterface */
    private $phpArrayToLinkCollectionEncoder;

    /** @var PhpArrayToMetaEncoderInterface */
    private $phpArrayToMetaEncoder;

    public function __construct(
        PhpArrayToRelationshipCollectionEncoderInterface $phpArrayToRelationshipCollectionEncoder,
        PhpArrayToAttributeCollectionEncoderInterface $phpArrayToAttributeCollectionEncoder,
        PhpArrayToLinkCollectionEncoderInterface $phpArrayToLinkCollectionEncoder,
        PhpArrayToMetaEncoderInterface $phpArrayToMetaEncoder
    ) {
        $this->phpArrayToRelationshipCollectionEncoder = $phpArrayToRelationshipCollectionEncoder;
        $this->phpArrayToAttributeCollectionEncoder = $phpArrayToAttributeCollectionEncoder;
        $this->phpArrayToLinkCollectionEncoder = $phpArrayToLinkCollectionEncoder;
        $this->phpArrayToMetaEncoder = $phpArrayToMetaEncoder;
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
            $this->phpArrayToAttributeCollectionEncoder->decode($rawAttributes),
            $this->phpArrayToRelationshipCollectionEncoder->decode($rawRelationships),
            null, // @todo parse self link
            $this->parseMeta($rawMeta)
        );
    }

    private function parseLinks(?array $rawLinks): ?LinkCollectionInterface
    {
        if (null === $rawLinks) {
            return null;
        }

        return $this->phpArrayToLinkCollectionEncoder->decode($rawLinks);
    }

    private function parseMeta(?array $rawMeta): ?MetaInterface
    {
        if (null === $rawMeta) {
            return null;
        }

        return $this->phpArrayToMetaEncoder->decode($rawMeta);
    }
}
