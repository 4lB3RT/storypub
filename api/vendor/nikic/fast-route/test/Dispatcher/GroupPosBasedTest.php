<?php

namespace Fast\Dispatcher;

class GroupPosBasedTest extends DispatcherTest {
    protected function getDispatcherClass() {
        return 'Fast\\Dispatcher\\GroupPosBased';
    }

    protected function getDataGeneratorClass() {
        return 'Fast\\DataGenerator\\GroupPosBased';
    }
}
