<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2017 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Slim\Interfaces;

use RuntimeException;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * r Interface
 *
 * @package Slim
 * @since   3.0.0
 */
interface rInterface
{
    // array keys from  result
    const DISPATCH_STATUS = 0;
    const ALLOWED_METHODS = 1;

    /**
     * Add
     *
     * @param string[] $methods Array of HTTP methods
     * @param string   $pattern The  pattern
     * @param callable $handler The  callable
     *
     * @return Interface
     */
    public function map($methods, $pattern, $handler);

    /**
     * Dispatch r for HTTP request
     *
     * @param  ServerRequestInterface $request The current HTTP request object
     *
     * @return array
     *
     * @link   https://github.com/nikic/Fast/blob/master/src/Dispatcher.php
     */
    public function dispatch(ServerRequestInterface $request);

    /**
     * Add a  group to the array
     *
     * @param string   $pattern The group pattern
     * @param callable $callable A group callable
     *
     * @return GroupInterface
     */
    public function pushGroup($pattern, $callable);

    /**
     * Removes the last  group from the array
     *
     * @return bool True if successful, else False
     */
    public function popGroup();

    /**
     * Get named  object
     *
     * @param string $name         name
     *
     * @return \Slim\Interfaces\Interface
     *
     * @throws RuntimeException   If named  does not exist
     */
    public function getNamed($name);

    /**
     * @param $identifier
     *
     * @return \Slim\Interfaces\Interface
     */
    public function lookup($identifier);

    /**
     * Build the path for a named  excluding the base path
     *
     * @param string $name         name
     * @param array  $data        Named argument replacement data
     * @param array  $queryParams Optional query string parameters
     *
     * @return string
     *
     * @throws RuntimeException         If named  does not exist
     * @throws InvalidArgumentException If required data not provided
     */
    public function relativePathFor($name, array $data = [], array $queryParams = []);

    /**
     * Build the path for a named  including the base path
     *
     * @param string $name         name
     * @param array  $data        Named argument replacement data
     * @param array  $queryParams Optional query string parameters
     *
     * @return string
     *
     * @throws RuntimeException         If named  does not exist
     * @throws InvalidArgumentException If required data not provided
     */
    public function pathFor($name, array $data = [], array $queryParams = []);
}
