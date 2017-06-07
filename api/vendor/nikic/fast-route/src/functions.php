<?php

namespace Fast;

if (!function_exists('Fast\simpleDispatcher')) {
    /**
     * @param callable $DefinitionCallback
     * @param array $options
     *
     * @return Dispatcher
     */
    function simpleDispatcher(callable $DefinitionCallback, array $options = []) {
        $options += [
            'Parser' => 'Fast\\Parser\\Std',
            'dataGenerator' => 'Fast\\DataGenerator\\GroupCountBased',
            'dispatcher' => 'Fast\\Dispatcher\\GroupCountBased',
            'Collector' => 'Fast\\Collector',
        ];

        /** @var Collector $Collector */
        $Collector = new $options['Collector'](
            new $options['Parser'], new $options['dataGenerator']
        );
        $DefinitionCallback($Collector);

        return new $options['dispatcher']($Collector->getData());
    }

    /**
     * @param callable $DefinitionCallback
     * @param array $options
     *
     * @return Dispatcher
     */
    function cachedDispatcher(callable $DefinitionCallback, array $options = []) {
        $options += [
            'Parser' => 'Fast\\Parser\\Std',
            'dataGenerator' => 'Fast\\DataGenerator\\GroupCountBased',
            'dispatcher' => 'Fast\\Dispatcher\\GroupCountBased',
            'Collector' => 'Fast\\Collector',
            'cacheDisabled' => false,
        ];

        if (!isset($options['cacheFile'])) {
            throw new \LogicException('Must specify "cacheFile" option');
        }

        if (!$options['cacheDisabled'] && file_exists($options['cacheFile'])) {
            $dispatchData = require $options['cacheFile'];
            if (!is_array($dispatchData)) {
                throw new \RuntimeException('Invalid cache file "' . $options['cacheFile'] . '"');
            }
            return new $options['dispatcher']($dispatchData);
        }

        $Collector = new $options['Collector'](
            new $options['Parser'], new $options['dataGenerator']
        );
        $DefinitionCallback($Collector);

        /** @var Collector $Collector */
        $dispatchData = $Collector->getData();
        if (!$options['cacheDisabled']) {
            file_put_contents(
                $options['cacheFile'],
                '<?php return ' . var_export($dispatchData, true) . ';'
            );
        }

        return new $options['dispatcher']($dispatchData);
    }
}
