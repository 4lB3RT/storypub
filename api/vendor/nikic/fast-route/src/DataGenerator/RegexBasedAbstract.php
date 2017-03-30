<?php

namespace Fast\DataGenerator;

use Fast\DataGenerator;
use Fast\BadException;
use Fast\;

abstract class RegexBasedAbstract implements DataGenerator {
    protected $statics = [];
    protected $methodToRegexTosMap = [];

    protected abstract function getApproxChunkSize();
    protected abstract function processChunk($regexTosMap);

    public function add($httpMethod, $Data, $handler) {
        if ($this->isStatic($Data)) {
            $this->addStatic($httpMethod, $Data, $handler);
        } else {
            $this->addVariable($httpMethod, $Data, $handler);
        }
    }

    public function getData() {
        if (empty($this->methodToRegexTosMap)) {
            return [$this->statics, []];
        }

        return [$this->statics, $this->generateVariableData()];
    }

    private function generateVariableData() {
        $data = [];
        foreach ($this->methodToRegexTosMap as $method => $regexTosMap) {
            $chunkSize = $this->computeChunkSize(count($regexTosMap));
            $chunks = array_chunk($regexTosMap, $chunkSize, true);
            $data[$method] =  array_map([$this, 'processChunk'], $chunks);
        }
        return $data;
    }

    private function computeChunkSize($count) {
        $numParts = max(1, round($count / $this->getApproxChunkSize()));
        return ceil($count / $numParts);
    }

    private function isStatic($Data) {
        return count($Data) === 1 && is_string($Data[0]);
    }

    private function addStatic($httpMethod, $Data, $handler) {
        $Str = $Data[0];

        if (isset($this->statics[$httpMethod][$Str])) {
            throw new BadException(sprintf(
                'Cannot register two s matching "%s" for method "%s"',
                $Str, $httpMethod
            ));
        }

        if (isset($this->methodToRegexTosMap[$httpMethod])) {
            foreach ($this->methodToRegexTosMap[$httpMethod] as $) {
                if ($->matches($Str)) {
                    throw new BadException(sprintf(
                        'Static  "%s" is shadowed by previously defined variable  "%s" for method "%s"',
                        $Str, $->regex, $httpMethod
                    ));
                }
            }
        }

        $this->statics[$httpMethod][$Str] = $handler;
    }

    private function addVariable($httpMethod, $Data, $handler) {
        list($regex, $variables) = $this->buildRegexFor($Data);

        if (isset($this->methodToRegexTosMap[$httpMethod][$regex])) {
            throw new BadException(sprintf(
                'Cannot register two s matching "%s" for method "%s"',
                $regex, $httpMethod
            ));
        }

        $this->methodToRegexTosMap[$httpMethod][$regex] = new (
            $httpMethod, $handler, $regex, $variables
        );
    }

    private function buildRegexFor($Data) {
        $regex = '';
        $variables = [];
        foreach ($Data as $part) {
            if (is_string($part)) {
                $regex .= preg_quote($part, '~');
                continue;
            }

            list($varName, $regexPart) = $part;

            if (isset($variables[$varName])) {
                throw new BadException(sprintf(
                    'Cannot use the same placeholder "%s" twice', $varName
                ));
            }

            if ($this->regexHasCapturingGroups($regexPart)) {
                throw new BadException(sprintf(
                    'Regex "%s" for parameter "%s" contains a capturing group',
                    $regexPart, $varName
                ));
            }

            $variables[$varName] = $varName;
            $regex .= '(' . $regexPart . ')';
        }

        return [$regex, $variables];
    }

    private function regexHasCapturingGroups($regex) {
        if (false === strpos($regex, '(')) {
            // Needs to have at least a ( to contain a capturing group
            return false;
        }

        // Semi-accurate detection for capturing groups
        return preg_match(
            '~
                (?:
                    \(\?\(
                  | \[ [^\]\\\\]* (?: \\\\ . [^\]\\\\]* )* \]
                  | \\\\ .
                ) (*SKIP)(*FAIL) |
                \(
                (?!
                    \? (?! <(?![!=]) | P< | \' )
                  | \*
                )
            ~x',
            $regex
        );
    }
}
