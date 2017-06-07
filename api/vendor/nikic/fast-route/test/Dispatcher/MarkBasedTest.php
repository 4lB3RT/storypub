<?php

namespace Fast\Dispatcher;

class MarkBasedTest extends DispatcherTest {
    public function setUp() {
        preg_match('/(*MARK:A)a/', 'a', $matches);
        if (!isset($matches['MARK'])) {
            $this->markTestSkipped('PHP 5.6 required for MARK support');
        }
    }

    protected function getDispatcherClass() {
        return 'Fast\\Dispatcher\\MarkBased';
    }

    protected function getDataGeneratorClass() {
        return 'Fast\\DataGenerator\\MarkBased';
    }
}
