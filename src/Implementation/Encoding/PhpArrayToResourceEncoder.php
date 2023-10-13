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
    private PhpArrayToRelationshipCollectionEncoderInterface $phpArrayToRelationshipCollectionEncoder;

    private PhpArrayToAttributeCollectionEncoderInterface $phpArrayToAttributeCollectionEncoder;

    private PhpArrayToMetaEncoderInterface $phpArrayToMetaEncoder;

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
     * @param array<string,mixed> $resource
     *
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

        $rawAttributes = \is_array($resource['attributes'] ?? null) ? $resource['attributes'] : [];
        $rawRelationships = \is_array($resource['relationships'] ?? null) ? $resource['relationships'] : [];
        $rawMeta = \is_array($resource['meta'] ?? null) ? $resource['meta'] : null;

        /** @var array{links: array{self: mixed}} $resource */
        $rawLink = $resource['links']['self'] ?? null;
        if (null !== $rawLink) {
            throw new \RuntimeException('Not implemented');
        }

        /** @var array{id: string, type: string, meta?: array<string, string>} $resource */
        return new Resource(
            $resource['id'],
            $resource['type'],
            $this->phpArrayToAttributeCollectionEncoder->encode($rawAttributes),
            $this->phpArrayToRelationshipCollectionEncoder->encode($rawRelationships),
            null,
            $this->parseMeta($rawMeta)
        );
    }

    /**
     * @param null|array<string,mixed> $rawMeta
     */
    private function parseMeta(?array $rawMeta): ?MetaInterface
    {
        if (null === $rawMeta) {
            return null;
        }

        return $this->phpArrayToMetaEncoder->decode($rawMeta);
    }
}
