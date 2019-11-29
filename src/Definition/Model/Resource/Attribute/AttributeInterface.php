<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Resource\Attribute;

interface AttributeInterface
{
    public function getName(): string;

    public function getValue();
}
