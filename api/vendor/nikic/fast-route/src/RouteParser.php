<?php

namespace Fast;

interface Parser {
    /**
     * Parses a  string into multiple  data arrays.
     *
     * The expected output is defined using an example:
     *
     * For the  string "/fixedPart/{varName}[/moreFixed/{varName2:\d+}]", if {varName} is interpreted as
     * a placeholder and [...] is interpreted as an optional  part, the expected result is:
     *
     * [
     *     // first : without optional part
     *     [
     *         "/fixedPart/",
     *         ["varName", "[^/]+"],
     *     ],
     *     // second : with optional part
     *     [
     *         "/fixedPart/",
     *         ["varName", "[^/]+"],
     *         "/moreFixed/",
     *         ["varName2", [0-9]+"],
     *     ],
     * ]
     *
     * Here one  string was converted into two  data arrays.
     *
     * @param string $  string to parse
     * 
     * @return mixed[][] Array of  data arrays
     */
    public function parse($);
}
