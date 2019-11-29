<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Error;

use InvalidArgumentException;
use Undabot\JsonApi\Model\Link\LinkInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Source\SourceInterface;

final class Error implements ErrorInterface
{
    /** @var string */
    private $id;

    /** @var LinkInterface */
    private $aboutLink;

    /**
     * the HTTP status code applicable to this problem, expressed as a string value.
     *
     * @var string|null
     */
    private $status;

    /**
     * an application-specific error code, expressed as a string value.
     *
     * @var string|null
     */
    private $code;

    /**
     * a short, human-readable summary of the problem that SHOULD NOT change from occurrence to
     * occurrence of the problem, except for purposes of localization.
     *
     * @var string|null
     */
    private $title;

    /**
     * detail: a human-readable explanation specific to this occurrence of the problem.
     * Like title, this field’s value can be localized.
     *
     * @var string|null
     */
    private $detail;

    /**
     * an object containing references to the source of the error
     *
     * @var SourceInterface|null
     */
    private $source;

    /**
     * an object containing references to the source of the error
     *
     * @var MetaInterface|null
     */
    private $meta;

    public function __construct(
        ?string $id,
        ?LinkInterface $aboutLink = null,
        ?string $status = null,
        ?string $code = null,
        ?string $title = null,
        ?string $detail = null,
        ?SourceInterface $source = null,
        ?MetaInterface $meta = null
    ) {
        if (null !== $aboutLink) {
            $this->makeSureAboutLinkIsNamedAbout($aboutLink);
            $this->aboutLink = $aboutLink;
        }

        if (null !== $id) {
            $this->id = $id;
        }

        if (null !== $status) {
            $this->status = $status;
        }

        if (null !== $code) {
            $this->code = $code;
        }

        if (null !== $title) {
            $this->title = $title;
        }

        if (null !== $detail) {
            $this->detail = $detail;
        }

        if (null !== $source) {
            $this->source = $source;
        }

        if (null !== $meta) {
            $this->meta = $meta;
        }
    }

    public static function withOnlyTitleAndDetail(string $title, string $detail): self
    {
        return new self(null, null, null, null, $title, $detail);
    }

    /**
     * Error should only have `about` link member
     *
     * @see https://jsonapi.org/format/#errors
     * links: a links object containing the following members:
     *   - about: a link that leads to further details about this particular occurrence of the problem.
     */
    private function makeSureAboutLinkIsNamedAbout(LinkInterface $link): void
    {
        if ('about' !== $link->getName()) {
            throw new InvalidArgumentException('Error links only should have about member');
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAboutLink(): ?LinkInterface
    {
        return $this->aboutLink;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function getSource(): ?SourceInterface
    {
        return $this->source;
    }

    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }
}
