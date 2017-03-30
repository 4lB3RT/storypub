<?php

namespace Fast\Dispatcher;

class MarkBased extends RegexBasedAbstract {
    public function __construct($data) {
        list($this->staticMap, $this->variableData) = $data;
    }

    protected function dispatchVariable($Data, $uri) {
        foreach ($Data as $data) {
            if (!preg_match($data['regex'], $uri, $matches)) {
                continue;
            }

            list($handler, $varNames) = $data['Map'][$matches['MARK']];

            $vars = [];
            $i = 0;
            foreach ($varNames as $varName) {
                $vars[$varName] = $matches[++$i];
            }
            return [self::FOUND, $handler, $vars];
        }

        return [self::NOT_FOUND];
    }
}
