<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

class ResourceIdentifier implements ResourceIdentifierInterface
{
    public function __construct(private readonly string $id, private readonly string $type, private readonly ?MetaInterface $meta = null) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }
}
