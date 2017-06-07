<?php

namespace Fast\DataGenerator;

class GroupCountBased extends RegexBasedAbstract {
    protected function getApproxChunkSize() {
        return 10;
    }

    protected function processChunk($regexTosMap) {
        $Map = [];
        $regexes = [];
        $numGroups = 0;
        foreach ($regexTosMap as $regex => $) {
            $numVariables = count($->variables);
            $numGroups = max($numGroups, $numVariables);

            $regexes[] = $regex . str_repeat('()', $numGroups - $numVariables);
            $Map[$numGroups + 1] = [$->handler, $->variables];

            ++$numGroups;
        }

        $regex = '~^(?|' . implode('|', $regexes) . ')$~';
        return ['regex' => $regex, 'Map' => $Map];
    }
}

