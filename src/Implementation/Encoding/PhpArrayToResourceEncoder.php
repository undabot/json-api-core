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
        PhpArrayToAttributeCollectionEncoderInterface $phpArrayToAttributeCollectionEncoder,
        PhpArrayToMetaEncoderInterface $phpArrayToMetaEncoder
    ) {
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

        $rawRelationships = $resource['relationships'] ?? [];
        $rawAttributes = $resource['attributes'] ?? [];
        $rawMeta = $resource['meta'] ?? null;
        $rawLink = $resource['links']['self'] ?? null;
        if (null !== $rawLink) {
            throw new \RuntimeException('Not implemented');
        }

        return new Resource(
            $resource['id'],
            $resource['type'],
            $this->phpArrayToAttributeCollectionEncoder->encode($rawAttributes),
            $this->phpArrayToRelationshipCollectionEncoder->encode($rawRelationships),
            null,
            $this->parseMeta($rawMeta)
        );
    }

    private function parseMeta(?array $rawMeta): ?MetaInterface
    {
        if (null === $rawMeta) {
            return null;
        }

        return $this->phpArrayToMetaEncoder->decode($rawMeta);
    }
}
