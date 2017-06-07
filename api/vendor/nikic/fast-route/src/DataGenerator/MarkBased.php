<?php

namespace Fast\DataGenerator;

class MarkBased extends RegexBasedAbstract {
    protected function getApproxChunkSize() {
        return 30;
    }

    protected function processChunk($regexTosMap) {
        $Map = [];
        $regexes = [];
        $markName = 'a';
        foreach ($regexTosMap as $regex => $) {
            $regexes[] = $regex . '(*MARK:' . $markName . ')';
            $Map[$markName] = [$->handler, $->variables];

            ++$markName;
        }

        $regex = '~^(?|' . implode('|', $regexes) . ')$~';
        return ['regex' => $regex, 'Map' => $Map];
    }
}

