<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\PhpArrayToAttributeCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToLinkCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToMetaEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToRelationshipCollectionEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\PhpArrayToResourceEncoderInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceInterface;
use Undabot\JsonApi\Implementation\Encoding\Exception\PhpArrayEncodingException;
use Undabot\JsonApi\Implementation\Model\Resource\Resource;
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

    /**
     * @throws PhpArrayEncodingException
     */
    public function decode(array $resource): ResourceInterface
    {
        try {
            $resourceValidationResult = Assert::validJsonResource($resource);
            if (false === $resourceValidationResult) {
                new PhpArrayEncodingException('Invalid JSON:API resource given');
            }
        } catch (AssertException $exception) {
            new PhpArrayEncodingException($exception->getMessage());
        }

        $rawRelationships = $resource['relationships'] ?? [];
        $rawAttributes = $resource['attributes'] ?? [];
        $rawMeta = $resource['meta'] ?? null;
        $rawLinks = $resource['links'] ?? null;

        return new Resource(
            $resource['id'],
            $resource['type'],
            $this->phpArrayToAttributeCollectionEncoder->encode($rawAttributes),
            $this->phpArrayToRelationshipCollectionEncoder->decode($rawRelationships),
            null, // @todo parse self link - generally not used as we don't expect links in the incoming resources
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
