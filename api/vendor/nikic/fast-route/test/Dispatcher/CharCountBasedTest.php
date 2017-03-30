<?php

namespace Fast\Dispatcher;

class CharCountBasedTest extends DispatcherTest {
    protected function getDispatcherClass() {
        return 'Fast\\Dispatcher\\CharCountBased';
    }

    protected function getDataGeneratorClass() {
        return 'Fast\\DataGenerator\\CharCountBased';
    }
}
