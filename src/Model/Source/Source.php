<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Source;

final class Source implements SourceInterface
{
    /**
     * a JSON Pointer [RFC6901] to the associated entity in the request document
     * [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute].
     *
     * @var string|null
     */
    private $pointer;

    /**
     * a string indicating which URI query parameter caused the error.
     *
     * @var string|null
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
