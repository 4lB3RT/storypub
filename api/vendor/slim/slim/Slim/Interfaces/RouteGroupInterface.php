<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2017 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Slim\Interfaces;

use Slim\App;

/**
 * Group Interface
 *
 * @package Slim
 * @since   3.0.0
 */
interface GroupInterface
{
    /**
     * Get  pattern
     *
     * @return string
     */
    public function getPattern();

    /**
     * Prepend middleware to the group middleware collection
     *
     * @param callable|string $callable The callback routine
     *
     * @return GroupInterface
     */
    public function add($callable);

    /**
     * Execute  group callable in the context of the Slim App
     *
     * This method invokes the  group object's callable, collecting
     * nested  objects
     *
     * @param App $app
     */
    public function __invoke(App $app);
}
