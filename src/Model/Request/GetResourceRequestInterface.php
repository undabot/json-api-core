<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Request;

use Undabot\JsonApi\Exception\Request\UnsupportedIncludeValuesGivenException;
use Undabot\JsonApi\Exception\Request\UnsupportedSparseFieldsetRequestedException;

interface GetResourceRequestInterface
{
    public function getId(): string;

    public function getInclude(): ?array;

    public function isIncluded(string $name): bool;

    public function getSparseFieldset(): ?array;

    /**
     * @param string[] $includes
     *
     * @throws UnsupportedIncludeValuesGivenException
     */
    public function allowIncludes(array $includes): self;

    /**
     * @param string[] $fields
     *
     * @throws UnsupportedSparseFieldsetRequestedException
     */
    public function allowFields(array $fields): self;
}
