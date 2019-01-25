<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource;

use Undabot\JsonApi\Model\Meta\MetaInterface;

interface ResourceIdentifierInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getMeta(): ?MetaInterface;
}
