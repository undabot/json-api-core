<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Document;

use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Document\DocumentDataInterface;
use Undabot\JsonApi\Definition\Model\Document\DocumentInterface;
use Undabot\JsonApi\Definition\Model\Error\ErrorCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Definition\Model\Link\LinkNamesEnum;
use Undabot\JsonApi\Definition\Model\Meta\MetaInterface;
use Undabot\JsonApi\Definition\Model\Resource\ResourceCollectionInterface;
use Undabot\JsonApi\Implementation\Model\Link\Link;

class Document implements DocumentInterface
{
    /** @var null|DocumentDataInterface */
    private $data;

    /** @var null|ErrorCollectionInterface */
    private $errors;

    /** @var null|MetaInterface */
    private $meta;

    /** @var null|MetaInterface */
    private $jsonApiMeta;

    /** @var null|LinkCollectionInterface */
    private $links;

    /** @var null|ResourceCollectionInterface */
    private $included;

    public function __construct(
        ?DocumentDataInterface $data,
        ?ErrorCollectionInterface $errors = null,
        ?MetaInterface $meta = null,
        ?MetaInterface $jsonApi = null,
        ?LinkCollectionInterface $links = null,
        ?ResourceCollectionInterface $included = null
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

    /**
     * The members data and errors MUST NOT coexist in the same document.
     */
    private function makeSureDataAndErrorsDontCoexist(
        ?DocumentDataInterface $data,
        ?ErrorCollectionInterface $errors
    ): void {
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
            if (false === \in_array($link->getName(), $validNames, true)) {
                throw new InvalidArgumentException("{$link->getName()} is not acceptable link");
            }
        }
    }

    /**
     * A document MUST contain at least one of the following top-level members.
     *
     * @see https://jsonapi.org/format/#document-top-level
     */
    private function makeSureAtLeastOneIsPresent(
        ?DocumentDataInterface $data,
        ?ErrorCollectionInterface $errors,
        ?MetaInterface $meta
    ): void {
        if (null === $errors
            && null === $data
            && null === $meta) {
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
}
