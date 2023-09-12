<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Factory;

use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Exception\Request\InvalidParameterValueException;
use Undabot\JsonApi\Definition\Model\Request\Pagination\PaginationInterface;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\CursorBasedPagination;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\OffsetBasedPagination;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\PageBasedPagination;
use Undabot\JsonApi\Implementation\Model\Source\Source;

class PaginationFactory
{
    /**
     * @param array<string, int> $paginationParams
     *
     * @throws \Assert\AssertionFailedException
     */
    public function fromArray(array $paginationParams): PaginationInterface
    {
        if (true === \array_key_exists(PageBasedPagination::PARAM_PAGE_SIZE, $paginationParams)
            && true === \array_key_exists(PageBasedPagination::PARAM_PAGE_NUMBER, $paginationParams)) {
            return $this->makePageBasedPagination($paginationParams);
        }

        if (true === \array_key_exists(OffsetBasedPagination::PARAM_PAGE_OFFSET, $paginationParams)
            && true === \array_key_exists(OffsetBasedPagination::PARAM_PAGE_LIMIT, $paginationParams)) {
            return $this->makeOffsetBasedPagination($paginationParams);
        }

        if (true === \array_key_exists(CursorBasedPagination::PARAM_PAGE_SIZE, $paginationParams)
            || true === \array_key_exists(CursorBasedPagination::PARAM_PAGE_AFTER, $paginationParams)
            || true === \array_key_exists(CursorBasedPagination::PARAM_PAGE_BEFORE, $paginationParams)) {
            return $this->makeCursorBasedPagination($paginationParams);
        }

        $message = sprintf('Couldn\'t create pagination from given params: %s', json_encode($paginationParams));

        throw new InvalidArgumentException($message);
    }

    /** @param array<string, int> $paginationParams */
    private function makePageBasedPagination(array $paginationParams): PageBasedPagination
    {
        Assertion::keyExists($paginationParams, PageBasedPagination::PARAM_PAGE_SIZE);
        Assertion::keyExists($paginationParams, PageBasedPagination::PARAM_PAGE_NUMBER);

        // Only whitelisted keys are allowed
        Assertion::allChoice(
            array_keys($paginationParams),
            [
                PageBasedPagination::PARAM_PAGE_SIZE,
                PageBasedPagination::PARAM_PAGE_NUMBER,
            ]
        );

        $this->validatePaginationParams($paginationParams);

        return new PageBasedPagination(
            (int) $paginationParams[PageBasedPagination::PARAM_PAGE_NUMBER],
            (int) $paginationParams[PageBasedPagination::PARAM_PAGE_SIZE],
        );
    }

    /** @param array<string, int> $paginationParams */
    private function makeOffsetBasedPagination(array $paginationParams): OffsetBasedPagination
    {
        Assertion::keyExists($paginationParams, OffsetBasedPagination::PARAM_PAGE_OFFSET);
        Assertion::keyExists($paginationParams, OffsetBasedPagination::PARAM_PAGE_LIMIT);

        // Only whitelisted keys are allowed
        Assertion::allChoice(
            array_keys($paginationParams),
            [
                OffsetBasedPagination::PARAM_PAGE_OFFSET,
                OffsetBasedPagination::PARAM_PAGE_LIMIT,
            ]
        );

        $this->validatePaginationParams($paginationParams);

        return new OffsetBasedPagination(
            (int) $paginationParams[OffsetBasedPagination::PARAM_PAGE_OFFSET],
            (int) $paginationParams[OffsetBasedPagination::PARAM_PAGE_LIMIT],
        );
    }

    /** @param array<string, int> $paginationParams */
    private function makeCursorBasedPagination(array $paginationParams): CursorBasedPagination
    {
        $size = $paginationParams[CursorBasedPagination::PARAM_PAGE_SIZE] ?? null;
        if (null !== $size) {
            $this->validatePaginationParams([CursorBasedPagination::PARAM_PAGE_SIZE => $paginationParams[CursorBasedPagination::PARAM_PAGE_SIZE]]);
        }

        return new CursorBasedPagination(
            $paginationParams[CursorBasedPagination::PARAM_PAGE_AFTER] ?? null,
            $paginationParams[CursorBasedPagination::PARAM_PAGE_BEFORE] ?? null,
            $size,
        );
    }


    /**
     * @param array<string, int> $paginationParams
     *
     * @throws InvalidParameterValueException
     * */
    private function validatePaginationParams(array $paginationParams): void
    {
        foreach ($paginationParams as $paginationParam) {
            try {
                Assertion::integerish($paginationParam);
                Assertion::greaterThan($paginationParam, 0);
            } catch (AssertionFailedException $exception) {
                throw new InvalidParameterValueException(
                    new Source(null, "page[$paginationParam]"),
                    "page[$paginationParam] must be a positive integer",
                    0,
                    $exception,
                );
            }
        }
    }
}
