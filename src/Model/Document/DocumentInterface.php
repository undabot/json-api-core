<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Document;

use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

interface DocumentInterface
{
    public function getData(): ?DocumentDataInterface;

    public function getErrors(): ?ErrorCollectionInterface;

    public function getMeta(): ?MetaInterface;

    public function getJsonApiMeta(): ?MetaInterface;

    public function getLinks(): ?LinkCollectionInterface;

    public function getIncluded(): ?ResourceCollectionInterface;
}
