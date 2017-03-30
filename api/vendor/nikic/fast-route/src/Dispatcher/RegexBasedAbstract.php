<?php

namespace Fast\Dispatcher;

use Fast\Dispatcher;

abstract class RegexBasedAbstract implements Dispatcher {
    protected $staticMap;
    protected $variableData;

    protected abstract function dispatchVariable($Data, $uri);

    public function dispatch($httpMethod, $uri) {
        if (isset($this->staticMap[$httpMethod][$uri])) {
            $handler = $this->staticMap[$httpMethod][$uri];
            return [self::FOUND, $handler, []];
        }

        $varData = $this->variableData;
        if (isset($varData[$httpMethod])) {
            $result = $this->dispatchVariable($varData[$httpMethod], $uri);
            if ($result[0] === self::FOUND) {
                return $result;
            }
        }

        // For HEAD requests, attempt fallback to GET
        if ($httpMethod === 'HEAD') {
            if (isset($this->staticMap['GET'][$uri])) {
                $handler = $this->staticMap['GET'][$uri];
                return [self::FOUND, $handler, []];
            }
            if (isset($varData['GET'])) {
                $result = $this->dispatchVariable($varData['GET'], $uri);
                if ($result[0] === self::FOUND) {
                    return $result;
                }
            }
        }

        // If nothing else matches, try fallback s
        if (isset($this->staticMap['*'][$uri])) {
            $handler = $this->staticMap['*'][$uri];
            return [self::FOUND, $handler, []];
        }
        if (isset($varData['*'])) {
            $result = $this->dispatchVariable($varData['*'], $uri);
            if ($result[0] === self::FOUND) {
                return $result;
            }
        }

        // Find allowed methods for this URI by matching against all other HTTP methods as well
        $allowedMethods = [];

        foreach ($this->staticMap as $method => $uriMap) {
            if ($method !== $httpMethod && isset($uriMap[$uri])) {
                $allowedMethods[] = $method;
            }
        }

        foreach ($varData as $method => $Data) {
            if ($method === $httpMethod) {
                continue;
            }

            $result = $this->dispatchVariable($Data, $uri);
            if ($result[0] === self::FOUND) {
                $allowedMethods[] = $method;
            }
        }

        // If there are no allowed methods the  simply does not exist
        if ($allowedMethods) {
            return [self::METHOD_NOT_ALLOWED, $allowedMethods];
        } else {
            return [self::NOT_FOUND];
        }
    }
}
