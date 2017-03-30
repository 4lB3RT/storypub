<?php

namespace Fast\DataGenerator;

class GroupPosBased extends RegexBasedAbstract {
    protected function getApproxChunkSize() {
        return 10;
    }

    protected function processChunk($regexTosMap) {
        $Map = [];
        $regexes = [];
        $offset = 1;
        foreach ($regexTosMap as $regex => $) {
            $regexes[] = $regex;
            $Map[$offset] = [$->handler, $->variables];

            $offset += count($->variables);
        }

        $regex = '~^(?:' . implode('|', $regexes) . ')$~';
        return ['regex' => $regex, 'Map' => $Map];
    }
}

