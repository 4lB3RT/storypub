<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2017 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Slim\Interfaces;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *  Interface
 *
 * @package Slim
 * @since   3.0.0
 */
interface Interface
{

    /**
     * Retrieve a specific  argument
     *
     * @param string $name
     * @param string|null $default
     *
     * @return string|null
     */
    public function getArgument($name, $default = null);

    /**
     * Get  arguments
     *
     * @return string[]
     */
    public function getArguments();

    /**
     * Get  name
     *
     * @return null|string
     */
    public function getName();

    /**
     * Get  pattern
     *
     * @return string
     */
    public function getPattern();

    /**
     * Set a  argument
     *
     * @param string $name
     * @param string $value
     *
     * @return self
     */
    public function setArgument($name, $value);

    /**
     * Replace  arguments
     *
     * @param string[] $arguments
     *
     * @return self
     */
    public function setArguments(array $arguments);

    /**
     * Set  name
     *
     * @param string $name
     *
     * @return static
     * @throws InvalidArgumentException if the  name is not a string
     */
    public function setName($name);

    /**
     * Add middleware
     *
     * This method prepends new middleware to the 's middleware stack.
     *
     * @param callable|string $callable The callback routine
     *
     * @return Interface
     */
    public function add($callable);

    /**
     * Prepare the  for use
     *
     * @param ServerRequestInterface $request
     * @param array $arguments
     */
    public function prepare(ServerRequestInterface $request, array $arguments);

    /**
     * Run
     *
     * This method traverses the middleware stack, including the 's callable
     * and captures the resultant HTTP response object. It then sends the response
     * back to the Application.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response);

    /**
     * Dispatch  callable against current Request and Response objects
     *
     * This method invokes the  object's callable. If middleware is
     * registered for the , each callable middleware is invoked in
     * the order specified.
     *
     * @param ServerRequestInterface $request  The current Request object
     * @param ResponseInterface      $response The current Response object
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response);
}
