<?php

namespace Fast\DataGenerator;

class CharCountBased extends RegexBasedAbstract {
    protected function getApproxChunkSize() {
        return 30;
    }

    protected function processChunk($regexTosMap) {
        $Map = [];
        $regexes = [];

        $suffixLen = 0;
        $suffix = '';
        $count = count($regexTosMap);
        foreach ($regexTosMap as $regex => $) {
            $suffixLen++;
            $suffix .= "\t";

            $regexes[] = '(?:' . $regex . '/(\t{' . $suffixLen . '})\t{' . ($count - $suffixLen) . '})';
            $Map[$suffix] = [$->handler, $->variables];
        }

        $regex = '~^(?|' . implode('|', $regexes) . ')$~';
        return ['regex' => $regex, 'suffix' => '/' . $suffix, 'Map' => $Map];
    }
}
