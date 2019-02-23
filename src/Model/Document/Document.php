<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Document;

use InvalidArgumentException;
use Undabot\JsonApi\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Model\Link\Link;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Link\LinkNamesEnum;
use Undabot\JsonApi\Model\Meta\JsonApiMeta;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\ResourceCollectionInterface;

class Document implements DocumentInterface
{
    /** @var DocumentDataInterface|null */
    private $data;

    /** @var ErrorCollectionInterface|null */
    private $errors;

    /** @var MetaInterface|null */
    private $meta;

    /** @var MetaInterface|null */
    private $jsonApiMeta;

    /** @var LinkCollectionInterface|null */
    private $links;

    /** @var ResourceCollectionInterface|null */
    private $included;

    public function __construct(
        ?DocumentDataInterface $data,
        ?ErrorCollectionInterface $errors = null,
        ?MetaInterface $meta = null,
        ?MetaInterface $jsonApi = null,
        ?LinkCollectionInterface $links = null,
        ResourceCollectionInterface $included = null
    ) {
        $this->makeSureAtLeastOneIsPresent($data, $errors, $meta);
        $this->makeSureDataAndErrorsDontCoexist($data, $errors);
        $this->makeSureOnlyValidLinksArePresent($links);
        $this->makeSureIncludedIsNotPresentWithoutData($data, $included);

        $this->data = $data;
        $this->errors = $errors;
        $this->meta = $meta;
        $this->jsonApiMeta = $jsonApi;
        $this->links = $links;
        $this->included = $included;
    }

    /**
     * The members data and errors MUST NOT coexist in the same document.
     */
    private function makeSureDataAndErrorsDontCoexist(?DocumentDataInterface $data, ?ErrorCollectionInterface $errors): void
    {
        $hasData = null !== $data;
        $hasErrors = null !== $errors;

        if (true === $hasData && true === $hasErrors) {
            throw new InvalidArgumentException('The members data and errors MUST NOT coexist in the same document.');
        }
    }

    /**
     * The top-level links object MAY contain the following members:
     * - self: the link that generated the current response document.
     * - related: a related resource link when the primary data represents a resource relationship.
     * - pagination links for the primary data.
     */
    private function makeSureOnlyValidLinksArePresent(?LinkCollectionInterface $links): void
    {
        if (null === $links) {
            return;
        }

        $validNames = [
            LinkNamesEnum::LINK_NAME_SELF,
            LinkNamesEnum::LINK_NAME_RELATED,
            LinkNamesEnum::LINK_NAME_PAGINATION_FIRST,
            LinkNamesEnum::LINK_NAME_PAGINATION_LAST,
            LinkNamesEnum::LINK_NAME_PAGINATION_NEXT,
            LinkNamesEnum::LINK_NAME_PAGINATION_PREV,
        ];

        /** @var Link $link */
        foreach ($links as $link) {
            if (false === in_array($link->getName(), $validNames)) {
                throw new InvalidArgumentException("{$link->getName()} is not acceptable link");
            }
        }
    }

    /**
     * A document MUST contain at least one of the following top-level members
     *
     * @see https://jsonapi.org/format/#document-top-level
     */
    private function makeSureAtLeastOneIsPresent(
        ?DocumentDataInterface $data,
        ?ErrorCollectionInterface $errors,
        ?MetaInterface $meta
    ): void {
        if (null === $errors &&
            null === $data &&
            null === $meta) {
            throw new InvalidArgumentException('A document MUST contain at least one of the following top-level members: data, errors, meta');
        }
    }

    /**
     * If a document does not contain a top-level data key, the included member MUST NOT be present either.
     */
    private function makeSureIncludedIsNotPresentWithoutData(
        ?DocumentDataInterface $data,
        ?ResourceCollectionInterface $included
    ): void {
        if (null === $data && null !== $included) {
            throw new InvalidArgumentException('a document does not contain a top-level data key, the included member MUST NOT be present either.');
        }
    }

    public function getData(): ?DocumentDataInterface
    {
        return $this->data;
    }

    public function getErrors(): ?ErrorCollectionInterface
    {
        return $this->errors;
    }

    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }

    public function getJsonApiMeta(): ?MetaInterface
    {
        return $this->jsonApiMeta;
    }

    public function getLinks(): ?LinkCollectionInterface
    {
        return $this->links;
    }

    public function getIncluded(): ?ResourceCollectionInterface
    {
        return $this->included;
    }
}
