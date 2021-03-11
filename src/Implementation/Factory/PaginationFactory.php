<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Implementation\Factory;

use Assert\Assertion;
use InvalidArgumentException;
use Undabot\JsonApi\Definition\Model\Request\Pagination\PaginationInterface;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\OffsetBasedPagination;
use Undabot\JsonApi\Implementation\Model\Request\Pagination\PageBasedPagination;

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

        $message = sprintf('Couldn\'t create pagination from given params: %s', json_encode($paginationParams));

        throw new InvalidArgumentException($message);
    }

    /**
     * @param array<string, int> $paginationParams
     *
     * @throws \Assert\AssertionFailedException
     */
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

        foreach ($paginationParams as $paginationParam) {
            Assertion::integerish(
                $paginationParam,
                sprintf('Params must be integer(ish): %s', $paginationParam)
            );
            Assertion::greaterThan(
                $paginationParam,
                0,
                sprintf('Params can\'t be zero: %s', $paginationParam)
            );
        }

        return new PageBasedPagination(
            (int) $paginationParams[PageBasedPagination::PARAM_PAGE_NUMBER],
            (int) $paginationParams[PageBasedPagination::PARAM_PAGE_SIZE]
        );
    }

    /**
     * @param array<string, int> $paginationParams
     *
     * @throws \Assert\AssertionFailedException
     */
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

        $limit = $paginationParams[OffsetBasedPagination::PARAM_PAGE_LIMIT];
        Assertion::integerish(
            $limit,
            sprintf('Param must be integer(ish): %s', $limit)
        );
        Assertion::greaterThan(
            $limit,
            0,
            sprintf('Param can\'t be zero: %s', $limit)
        );

        $offset = $paginationParams[OffsetBasedPagination::PARAM_PAGE_OFFSET];
        Assertion::integerish(
            $offset,
            sprintf('Param must be integer(ish): %s', $offset)
        );

        return new OffsetBasedPagination(
            (int) $paginationParams[OffsetBasedPagination::PARAM_PAGE_OFFSET],
            (int) $paginationParams[OffsetBasedPagination::PARAM_PAGE_LIMIT]
        );
    }
}
