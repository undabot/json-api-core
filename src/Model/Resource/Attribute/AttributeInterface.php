<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Attribute;

interface AttributeInterface
{
    public function getName(): string;

    public function getValue();
}
