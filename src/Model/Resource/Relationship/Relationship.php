<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Relationship;

use InvalidArgumentException;
use Undabot\JsonApi\Model\Link\LinkCollectionInterface;
use Undabot\JsonApi\Model\Meta\MetaInterface;
use Undabot\JsonApi\Model\Resource\Relationship\Data\RelationshipDataInterface;

class Relationship implements RelationshipInterface
{
    /** @var string */
    private $name;

    /** @var LinkCollectionInterface|null */
    private $links;

    /** @var RelationshipDataInterface|null */
    private $data;

    /** @var MetaInterface|null */
    private $meta;

    public function __construct(
        string $name,
        ?LinkCollectionInterface $links = null,
        ?RelationshipDataInterface $data = null,
        ?MetaInterface $meta = null
    ) {
        $this->name = $name;

        /*
        A “relationship object” MUST contain at least one of the following:

        links: a links object containing at least one of the following:
        - self: a link for the relationship itself (a “relationship link”). This link allows the client to directly manipulate the relationship. For example, removing an author through an article’s relationship URL would disconnect the person from the article without deleting the people resource itself. When fetched successfully, this link returns the linkage for the related resources as its primary data. (See Fetching Relationships.)
        - related: a related resource link
        data: resource linkage
        meta: a meta object that contains non-standard meta-information about the relationship.
        */

        if (null === $links &&
            null === $data &&
            null === $meta) {
            throw new InvalidArgumentException('A “relationship object” MUST contain at least one of the following: links, data, meta');
        }

        if (null !== $links) {
            $this->makeSureLinksAreEitherSelfOrRelated($links);
        }

        $this->links = $links;
        $this->data = $data;
        $this->meta = $meta;
    }

    private function makeSureLinksAreEitherSelfOrRelated(LinkCollectionInterface $links): void
    {
        $linkNames = $links->getLinkNames();

        $allowedLinks = ['self', 'related'];

        $disallowedLinks = array_diff($linkNames, $allowedLinks);

        if (0 !== count($disallowedLinks)) {
            $message = sprintf('Relationship can only have `self` and `related` links, %s given.',
                (implode(', ', $disallowedLinks)));
            throw new InvalidArgumentException($message);
        }

        // @todo A relationship object that represents a to-many relationship MAY
        // also contain pagination links under the links member, as described below.
        // Any pagination links in a relationship object MUST paginate the relationship data, not the related resources.
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLinks(): ?LinkCollectionInterface
    {
        return $this->links;
    }

    public function getData(): ?RelationshipDataInterface
    {
        return $this->data;
    }

    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }
}
