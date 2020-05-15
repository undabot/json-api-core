<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Definition\Model\Request;

use Undabot\JsonApi\Definition\Exception\Request\UnsupportedIncludeValuesGivenException;
use Undabot\JsonApi\Definition\Exception\Request\UnsupportedSparseFieldsetRequestedException;

interface GetResourceRequestInterface
{
    public function getId(): string;

    public function getIncludes(): ?array;

    public function isIncluded(string $name): bool;

    public function getSparseFieldset(): ?array;

    /**
     * @param string[] $allowedIncludes
     *
     * @throws UnsupportedIncludeValuesGivenException
     */
    public function allowIncluded(array $allowedIncludes): self;

    /**
     * @param string[] $fields
     *
     * @throws UnsupportedSparseFieldsetRequestedException
     */
    public function allowFields(array $fields): self;
}
