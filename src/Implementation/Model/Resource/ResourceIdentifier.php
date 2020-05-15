<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource;

use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceIdentifierInterface;

class ResourceIdentifier implements ResourceIdentifierInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $type;

    /** @var null|MetaInterface */
    private $meta;

    public function __construct(string $id, string $type, ?MetaInterface $meta = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->meta = $meta;
    }

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
