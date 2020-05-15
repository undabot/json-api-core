<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Document;

use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;

interface DocumentInterface
{
    public function getData(): ?DocumentDataInterface;

    public function getErrors(): ?ErrorCollectionInterface;

    public function getMeta(): ?MetaInterface;

    public function getJsonApiMeta(): ?MetaInterface;

    public function getLinks(): ?LinkCollectionInterface;

    public function getIncluded(): ?ResourceCollectionInterface;
}
