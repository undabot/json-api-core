<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Source;

interface SourceInterface
{
    public function getPointer(): ?string;

    public function getParameter(): ?string;
}
