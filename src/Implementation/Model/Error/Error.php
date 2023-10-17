<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Error;

use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

/** @psalm-suppress UnusedClass */
final class Error implements ErrorInterface
{
    private ?string $id;

    private ?LinkInterface $aboutLink;

    /**
     * the HTTP status code applicable to this problem, expressed as a string value.
     */
    private ?string $status;

    /**
     * an application-specific error code, expressed as a string value.
     */
    private ?string $code;

    /**
     * a short, human-readable summary of the problem that SHOULD NOT change from occurrence to
     * occurrence of the problem, except for purposes of localization.
     */
    private ?string $title;

    /**
     * detail: a human-readable explanation specific to this occurrence of the problem.
     * Like title, this field’s value can be localized.
     */
    private ?string $detail;

    /**
     * an object containing references to the source of the error.
     *
     * @var null|SourceInterface
     */
    private $source;

    /**
     * an object containing references to the source of the error.
     */
    private ?MetaInterface $meta;

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
        $this->makeSureAboutLinkIsNamedAbout($aboutLink);
        $this->aboutLink = $aboutLink;

        $this->id = $id;
        $this->status = $status;

        $this->code = $code;

        $this->title = $title;

        $this->detail = $detail;

        $this->source = $source;

        $this->meta = $meta;
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

    /**
     * Error should only have `about` link member.
     *
     * @see https://jsonapi.org/format/#errors
     * links: a links object containing the following members:
     *   - about: a link that leads to further details about this particular occurrence of the problem.
     */
    private function makeSureAboutLinkIsNamedAbout(?LinkInterface $link): void
    {
        if (null !== $link && 'about' !== $link->getName()) {
            throw new \InvalidArgumentException('Error links only should have about member');
        }
    }
}
