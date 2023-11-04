<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Attribute;

use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeInterface;

/** @psalm-suppress UnusedClass */
class AttributeCollection implements AttributeCollectionInterface
{
    /** @var AttributeInterface[] */
    private array $attributes;

    /** @param AttributeInterface[] $attributes */
    public function __construct(array $attributes)
    {
        $this->makeSureAllAttributesAreValid($attributes);
        $this->attributes = $attributes;
    }

    /** @return AttributeInterface[] */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return \ArrayIterator<int,AttributeInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->getAttributes());
    }

    public function getAttributeByName(string $name): ?AttributeInterface
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getName() === $name) {
                return $attribute;
            }
        }

        return null;
    }

    /** @param AttributeInterface[] $attributes */
    private function makeSureAllAttributesAreValid(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            if (false === ($attribute instanceof Attribute)) {
                $message = sprintf('Attribute expected, %s given', \get_class($attribute));

                throw new \InvalidArgumentException($message);
            }
        }
    }
}
