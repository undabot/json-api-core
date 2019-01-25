<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Model\Resource\Attribute;

use ArrayIterator;
use InvalidArgumentException;

class AttributeCollection implements AttributeCollectionInterface
{
    /** @var Attribute[] */
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->makeSureAllAttributesAreValid($attributes);
        $this->attributes = $attributes;
    }

    private function makeSureAllAttributesAreValid(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            if (false === ($attribute instanceof Attribute)) {
                $message = sprintf('Attribute expected, %s given', get_class($attribute));
                throw new InvalidArgumentException($message);
            }
        }
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
}
