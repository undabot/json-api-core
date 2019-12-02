<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

class ValidMemberNameAssertion
{
    public function assert(string $memberName): bool
    {
        return $this->checkNotEmptyString($memberName) && $this->checkContainsOnlyAllowedCharacters($memberName);
    }

    private function checkNotEmptyString(string $memberName): bool
    {
        return '' !== $memberName;
    }

    /**
     * The following “globally allowed characters” MAY be used *anywhere* in a member name:
     * U+0061 to U+007A, “a-z”
     * U+0041 to U+005A, “A-Z”
     * U+0030 to U+0039, “0-9”.
     *
     * Additionally, the following characters are allowed
     * in member names, except as the first or last
     * character:
     *
     * U+002D HYPHEN-MINUS, “-“
     * U+005F LOW LINE, “_”
     */
    private function checkContainsOnlyAllowedCharacters(string $memberName): bool
    {
        if (!preg_match('/^(?:([a-zA-Z0-9]+)|([a-zA-Z0-9][a-zA-Z0-9_-]*[a-zA-Z0-9]+))$/', $memberName)) {
            return false;
        }

        return true;
    }
}
