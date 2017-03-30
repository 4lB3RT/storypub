<?php

namespace Fast;

interface DataGenerator {
    /**
     * Adds a  to the data generator. The  data uses the
     * same format that is returned by rParser::parser().
     *
     * The handler doesn't necessarily need to be a callable, it
     * can be arbitrary data that will be returned when the
     * matches.
     *
     * @param string $httpMethod
     * @param array $Data
     * @param mixed $handler
     */
    public function add($httpMethod, $Data, $handler);

    /**
     * Returns dispatcher data in some unspecified format, which
     * depends on the used method of dispatch.
     */
    public function getData();
}
