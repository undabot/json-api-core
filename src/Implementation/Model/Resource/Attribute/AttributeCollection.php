<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Model\Resource\Attribute;

use ArrayIterator;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeCollectionInterface;
use Undabot\JsonApi\Definition\Model\Resource\Attribute\AttributeInterface;

class AttributeCollection implements AttributeCollectionInterface
{
    /** @var Attribute[] */
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->makeSureAllAttributesAreValid($attributes);
        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getAttributes());
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

    private function makeSureAllAttributesAreValid(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            if (false === ($attribute instanceof Attribute)) {
                $message = sprintf('Attribute expected, %s given', \get_class($attribute));

                throw new InvalidArgumentException($message);
            }
        }
    }
}
