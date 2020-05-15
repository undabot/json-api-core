<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Error;

use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

interface ErrorInterface
{
    public function getId(): ?string;

    public function getAboutLink(): ?LinkInterface;

    public function getStatus(): ?string;

    public function getCode(): ?string;

    public function getTitle(): ?string;

    public function getDetail(): ?string;

    public function getSource(): ?SourceInterface;

    public function getMeta(): ?MetaInterface;
}
