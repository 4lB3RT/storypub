<?php

namespace Fast\Dispatcher;

class GroupCountBasedTest extends DispatcherTest {
    protected function getDispatcherClass() {
        return 'Fast\\Dispatcher\\GroupCountBased';
    }

    protected function getDataGeneratorClass() {
        return 'Fast\\DataGenerator\\GroupCountBased';
    }
}
