<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Encoding;

use Undabot\JsonApi\Definition\Encoding\MetaToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Encoding\ResourceIdentifierToPhpArrayEncoderInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

/** @psalm-suppress UnusedClass */
class ResourceIdentifierToPhpArrayEncoder implements ResourceIdentifierToPhpArrayEncoderInterface
{
    /** @var MetaToPhpArrayEncoderInterface */
    private $metaToPhpArrayEncoder;

    /** @psalm-suppress PossiblyUnusedMethod */
    public function __construct(MetaToPhpArrayEncoderInterface $metaToPhpArrayEncoder)
    {
        $this->metaToPhpArrayEncoder = $metaToPhpArrayEncoder;
    }

    /** @return array<string,mixed> */
    public function encode(ResourceIdentifierInterface $resourceIdentifier): array
    {
        $serializedResourceIdentifier = [
            'type' => $resourceIdentifier->getType(),
            'id' => $resourceIdentifier->getId(),
        ];

        $resourceIdentifier = $resourceIdentifier->getMeta();
        if (null !== $resourceIdentifier) {
            $serializedResourceIdentifier['meta'] = $this->metaToPhpArrayEncoder->encode($resourceIdentifier);
        }

        return $serializedResourceIdentifier;
    }
}
