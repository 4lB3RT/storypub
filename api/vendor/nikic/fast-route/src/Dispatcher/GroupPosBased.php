<?php

namespace Fast\Dispatcher;

class GroupPosBased extends RegexBasedAbstract {
    public function __construct($data) {
        list($this->staticMap, $this->variableData) = $data;
    }

    protected function dispatchVariable($Data, $uri) {
        foreach ($Data as $data) {
            if (!preg_match($data['regex'], $uri, $matches)) {
                continue;
            }

            // find first non-empty match
            for ($i = 1; '' === $matches[$i]; ++$i);

            list($handler, $varNames) = $data['Map'][$i];

            $vars = [];
            foreach ($varNames as $varName) {
                $vars[$varName] = $matches[$i++];
            }
            return [self::FOUND, $handler, $vars];
        }

        return [self::NOT_FOUND];
    }
}
