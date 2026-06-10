<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Error;

use Undabot\JsonApi\Definition\Model\Error\ErrorInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkInterface;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Source\SourceInterface;

final class Error implements ErrorInterface
{
    /**
     * @param null|string          $status the HTTP status code applicable to this problem, expressed as a string value
     * @param null|string          $code   an application-specific error code, expressed as a string value
     * @param null|string          $title  a short, human-readable summary of the problem that SHOULD NOT change from
     *                                     occurrence to occurrence of the problem, except for purposes of localization
     * @param null|string          $detail a human-readable explanation specific to this occurrence of the problem.
     *                                     Like title, this field's value can be localized.
     * @param null|SourceInterface $source an object containing references to the source of the error
     * @param null|MetaInterface   $meta   a meta object containing non-standard meta-information about the error
     */
    public function __construct(
        private readonly ?string $id,
        private readonly ?LinkInterface $aboutLink = null,
        private readonly ?string $status = null,
        private readonly ?string $code = null,
        private readonly ?string $title = null,
        private readonly ?string $detail = null,
        private readonly ?SourceInterface $source = null,
        private readonly ?MetaInterface $meta = null,
    ) {
        if (null !== $aboutLink) {
            $this->makeSureAboutLinkIsNamedAbout($aboutLink);
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

    /**
     * Error should only have `about` link member.
     *
     * @see https://jsonapi.org/format/#errors
     * links: a links object containing the following members:
     *   - about: a link that leads to further details about this particular occurrence of the problem.
     */
    private function makeSureAboutLinkIsNamedAbout(LinkInterface $link): void
    {
        if ('about' !== $link->getName()) {
            throw new \InvalidArgumentException('Error links only should have about member');
        }
    }
}
