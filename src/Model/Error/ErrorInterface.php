<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Error;

use Undabot\JsonApi\Model\Link\LinkInterface;
use Undabot\JsonApi\Model\Meta\Meta;
use Undabot\JsonApi\Model\Source\Source;

interface ErrorInterface
{
    public function getId(): ?string;

    public function getAboutLink(): LinkInterface;

    public function getStatus(): ?string;

    public function getCode(): ?string;

    public function getTitle(): ?string;

    public function getDetail(): ?string;

    public function getSource(): Source;

    public function getMeta(): Meta;
}
