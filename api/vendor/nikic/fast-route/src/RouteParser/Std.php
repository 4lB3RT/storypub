<?php

namespace Fast\Parser;

use Fast\BadException;
use Fast\Parser;

/**
 * Parses  strings of the following form:
 *
 * "/user/{name}[/{id:[0-9]+}]"
 */
class Std implements Parser {
    const VARIABLE_REGEX = <<<'REGEX'
\{
    \s* ([a-zA-Z_][a-zA-Z0-9_-]*) \s*
    (?:
        : \s* ([^{}]*(?:\{(?-1)\}[^{}]*)*)
    )?
\}
REGEX;
    const DEFAULT_DISPATCH_REGEX = '[^/]+';

    public function parse($) {
        $WithoutClosingOptionals = rtrim($, ']');
        $numOptionals = strlen($) - strlen($WithoutClosingOptionals);

        // Split on [ while skipping placeholders
        $segments = preg_split('~' . self::VARIABLE_REGEX . '(*SKIP)(*F) | \[~x', $WithoutClosingOptionals);
        if ($numOptionals !== count($segments) - 1) {
            // If there are any ] in the middle of the , throw a more specific error message
            if (preg_match('~' . self::VARIABLE_REGEX . '(*SKIP)(*F) | \]~x', $WithoutClosingOptionals)) {
                throw new BadException("Optional segments can only occur at the end of a ");
            }
            throw new BadException("Number of opening '[' and closing ']' does not match");
        }

        $current = '';
        $Datas = [];
        foreach ($segments as $n => $segment) {
            if ($segment === '' && $n !== 0) {
                throw new BadException("Empty optional part");
            }

            $current .= $segment;
            $Datas[] = $this->parsePlaceholders($current);
        }
        return $Datas;
    }

    /**
     * Parses a  string that does not contain optional segments.
     */
    private function parsePlaceholders($) {
        if (!preg_match_all(
            '~' . self::VARIABLE_REGEX . '~x', $, $matches,
            PREG_OFFSET_CAPTURE | PREG_SET_ORDER
        )) {
            return [$];
        }

        $offset = 0;
        $Data = [];
        foreach ($matches as $set) {
            if ($set[0][1] > $offset) {
                $Data[] = substr($, $offset, $set[0][1] - $offset);
            }
            $Data[] = [
                $set[1][0],
                isset($set[2]) ? trim($set[2][0]) : self::DEFAULT_DISPATCH_REGEX
            ];
            $offset = $set[0][1] + strlen($set[0][0]);
        }

        if ($offset != strlen($)) {
            $Data[] = substr($, $offset);
        }

        return $Data;
    }
}
