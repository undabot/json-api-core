<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource;

use Undabot\JsonApi\Model\Meta\MetaInterface;

class ResourceIdentifier implements ResourceIdentifierInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $type;

    /** @var MetaInterface|null */
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
