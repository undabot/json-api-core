<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Source;

use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

final class Source implements SourceInterface
{
    /**
     * a JSON Pointer [RFC6901] to the associated entity in the request document
     * [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute].
     *
     * @var null|string
     */
    private $pointer;

    /**
     * a string indicating which URI query parameter caused the error.
     *
     * @var null|string
     */
    private $parameter;

    public function __construct(?string $pointer, ?string $parameter = null)
    {
        if (null !== $pointer) {
            $this->pointer = $pointer;
        }

        if (null !== $parameter) {
            $this->parameter = $parameter;
        }
    }

    public function getPointer(): ?string
    {
        return $this->pointer;
    }

    public function getParameter(): ?string
    {
        return $this->parameter;
    }
}
