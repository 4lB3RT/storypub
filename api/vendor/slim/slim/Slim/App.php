<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2017 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Slim;

use Exception;
use Slim\Exception\InvalidMethodException;
use Slim\Http\Response;
use Throwable;
use Closure;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use Fast\Dispatcher;
use Slim\Exception\SlimException;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;
use Slim\Http\Uri;
use Slim\Http\Headers;
use Slim\Http\Body;
use Slim\Http\Request;
use Slim\Interfaces\Http\EnvironmentInterface;
use Slim\Interfaces\GroupInterface;
use Slim\Interfaces\Interface;
use Slim\Interfaces\rInterface;

/**
 * App
 *
 * This is the primary class with which you instantiate,
 * configure, and run a Slim Framework application.
 * The \Slim\App class also accepts Slim Framework middleware.
 *
 * @property-read callable $errorHandler
 * @property-read callable $phpErrorHandler
 * @property-read callable $notFoundHandler function($request, $response)
 * @property-read callable $notAllowedHandler function($request, $response, $allowedHttpMethods)
 */
class App
{
    use MiddlewareAwareTrait;

    /**
     * Current version
     *
     * @var string
     */
    const VERSION = '3.8.1';

    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /********************************************************************************
     * Constructor
     *******************************************************************************/

    /**
     * Create new application
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an associative array of app settings
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;
    }

    /**
     * Enable access to the DI container by consumers of $app
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Add middleware
     *
     * This method prepends new middleware to the app's middleware stack.
     *
     * @param  callable|string    $callable The callback routine
     *
     * @return static
     */
    public function add($callable)
    {
        return $this->addMiddleware(new DeferredCallable($callable, $this->container));
    }

    /**
     * Calling a non-existant method on App checks to see if there's an item
     * in the container that is callable and if so, calls it.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            $obj = $this->container->get($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }
        }

        throw new \BadMethodCallException("Method $method is not a valid method");
    }

    /********************************************************************************
     * r proxy methods
     *******************************************************************************/

    /**
     * Add GET
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function get($pattern, $callable)
    {
        return $this->map(['GET'], $pattern, $callable);
    }

    /**
     * Add POST
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function post($pattern, $callable)
    {
        return $this->map(['POST'], $pattern, $callable);
    }

    /**
     * Add PUT
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function put($pattern, $callable)
    {
        return $this->map(['PUT'], $pattern, $callable);
    }

    /**
     * Add PATCH
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function patch($pattern, $callable)
    {
        return $this->map(['PATCH'], $pattern, $callable);
    }

    /**
     * Add DELETE
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function delete($pattern, $callable)
    {
        return $this->map(['DELETE'], $pattern, $callable);
    }

    /**
     * Add OPTIONS
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function options($pattern, $callable)
    {
        return $this->map(['OPTIONS'], $pattern, $callable);
    }

    /**
     * Add  for any HTTP method
     *
     * @param  string $pattern  The  URI pattern
     * @param  callable|string  $callable The  callback routine
     *
     * @return \Slim\Interfaces\Interface
     */
    public function any($pattern, $callable)
    {
        return $this->map(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], $pattern, $callable);
    }

    /**
     * Add  with multiple methods
     *
     * @param  string[] $methods  Numeric array of HTTP method names
     * @param  string   $pattern  The  URI pattern
     * @param  callable|string    $callable The  callback routine
     *
     * @return Interface
     */
    public function map(array $methods, $pattern, $callable)
    {
        if ($callable instanceof Closure) {
            $callable = $callable->bindTo($this->container);
        }

        $ = $this->container->get('r')->map($methods, $pattern, $callable);
        if (is_callable([$, 'setContainer'])) {
            $->setContainer($this->container);
        }

        if (is_callable([$, 'setOutputBuffering'])) {
            $->setOutputBuffering($this->container->get('settings')['outputBuffering']);
        }

        return $;
    }

    /**
     *  Groups
     *
     * This method accepts a  pattern and a callback. All
     * declarations in the callback will be prepended by the group(s)
     * that it is in.
     *
     * @param string   $pattern
     * @param callable $callable
     *
     * @return GroupInterface
     */
    public function group($pattern, $callable)
    {
        /** @var Group $group */
        $group = $this->container->get('r')->pushGroup($pattern, $callable);
        $group->setContainer($this->container);
        $group($this);
        $this->container->get('r')->popGroup();
        return $group;
    }

    /********************************************************************************
     * Runner
     *******************************************************************************/

    /**
     * Run application
     *
     * This method traverses the application middleware stack and then sends the
     * resultant Response object to the HTTP client.
     *
     * @param bool|false $silent
     * @return ResponseInterface
     *
     * @throws Exception
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function run($silent = false)
    {
        $response = $this->container->get('response');

        try {
            $response = $this->process($this->container->get('request'), $response);
        } catch (InvalidMethodException $e) {
            $response = $this->processInvalidMethod($e->getRequest(), $response);
        }

        if (!$silent) {
            $this->respond($response);
        }

        return $response;
    }

    /**
     * Pull  info for a request with a bad method to decide whether to
     * return a not-found error (default) or a bad-method error, then run
     * the handler for that error, returning the resulting response.
     *
     * Used for cases where an incoming request has an unrecognized method,
     * rather than throwing an exception and not catching it all the way up.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function processInvalidMethod(ServerRequestInterface $request, ResponseInterface $response)
    {
        $r = $this->container->get('r');
        if (is_callable([$request->getUri(), 'getBasePath']) && is_callable([$r, 'setBasePath'])) {
            $r->setBasePath($request->getUri()->getBasePath());
        }

        $request = $this->dispatchrAndPrepare($request, $r);
        $Info = $request->getAttribute('Info', [rInterface::DISPATCH_STATUS => Dispatcher::NOT_FOUND]);

        if ($Info[rInterface::DISPATCH_STATUS] === Dispatcher::METHOD_NOT_ALLOWED) {
            return $this->handleException(
                new MethodNotAllowedException($request, $response, $Info[rInterface::ALLOWED_METHODS]),
                $request,
                $response
            );
        }

        return $this->handleException(new NotFoundException($request, $response), $request, $response);
    }

    /**
     * Process a request
     *
     * This method traverses the application middleware stack and then returns the
     * resultant Response object.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     *
     * @throws Exception
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function process(ServerRequestInterface $request, ResponseInterface $response)
    {
        // Ensure basePath is set
        $r = $this->container->get('r');
        if (is_callable([$request->getUri(), 'getBasePath']) && is_callable([$r, 'setBasePath'])) {
            $r->setBasePath($request->getUri()->getBasePath());
        }

        // Dispatch the r first if the setting for this is on
        if ($this->container->get('settings')['determineBeforeAppMiddleware'] === true) {
            // Dispatch r (note: you won't be able to alter s after this)
            $request = $this->dispatchrAndPrepare($request, $r);
        }

        // Traverse middleware stack
        try {
            $response = $this->callMiddlewareStack($request, $response);
        } catch (Exception $e) {
            $response = $this->handleException($e, $request, $response);
        } catch (Throwable $e) {
            $response = $this->handlePhpError($e, $request, $response);
        }

        $response = $this->finalize($response);

        return $response;
    }

    /**
     * Send the response the client
     *
     * @param ResponseInterface $response
     */
    public function respond(ResponseInterface $response)
    {
        // Send response
        if (!headers_sent()) {
            // Status
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));

            // Headers
            foreach ($response->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }

        // Body
        if (!$this->isEmptyResponse($response)) {
            $body = $response->getBody();
            if ($body->isSeekable()) {
                $body->rewind();
            }
            $settings       = $this->container->get('settings');
            $chunkSize      = $settings['responseChunkSize'];

            $contentLength  = $response->getHeaderLine('Content-Length');
            if (!$contentLength) {
                $contentLength = $body->getSize();
            }


            if (isset($contentLength)) {
                $amountToRead = $contentLength;
                while ($amountToRead > 0 && !$body->eof()) {
                    $data = $body->read(min($chunkSize, $amountToRead));
                    echo $data;

                    $amountToRead -= strlen($data);

                    if (connection_status() != CONNECTION_NORMAL) {
                        break;
                    }
                }
            } else {
                while (!$body->eof()) {
                    echo $body->read($chunkSize);
                    if (connection_status() != CONNECTION_NORMAL) {
                        break;
                    }
                }
            }
        }
    }

    /**
     * Invoke application
     *
     * This method implements the middleware interface. It receives
     * Request and Response objects, and it returns a Response object
     * after compiling the s registered in the r and dispatching
     * the Request object to the appropriate  callback routine.
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        // Get the  info
        $Info = $request->getAttribute('Info');

        /** @var \Slim\Interfaces\rInterface $r */
        $r = $this->container->get('r');

        // If r hasn't been dispatched or the URI changed then dispatch
        if (null === $Info || ($Info['request'] !== [$request->getMethod(), (string) $request->getUri()])) {
            $request = $this->dispatchrAndPrepare($request, $r);
            $Info = $request->getAttribute('Info');
        }

        if ($Info[0] === Dispatcher::FOUND) {
            $ = $r->lookup($Info[1]);
            return $->run($request, $response);
        } elseif ($Info[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            if (!$this->container->has('notAllowedHandler')) {
                throw new MethodNotAllowedException($request, $response, $Info[1]);
            }
            /** @var callable $notAllowedHandler */
            $notAllowedHandler = $this->container->get('notAllowedHandler');
            return $notAllowedHandler($request, $response, $Info[1]);
        }

        if (!$this->container->has('notFoundHandler')) {
            throw new NotFoundException($request, $response);
        }
        /** @var callable $notFoundHandler */
        $notFoundHandler = $this->container->get('notFoundHandler');
        return $notFoundHandler($request, $response);
    }

    /**
     * Perform a sub-request from within an application
     *
     * This method allows you to prepare and initiate a sub-request, run within
     * the context of the current request. This WILL NOT issue a remote HTTP
     * request. Instead, it will  the provided URL, method, headers,
     * cookies, body, and server variables against the set of registered
     * application s. The result response object is returned.
     *
     * @param  string            $method      The request method (e.g., GET, POST, PUT, etc.)
     * @param  string            $path        The request URI path
     * @param  string            $query       The request URI query string
     * @param  array             $headers     The request headers (key-value array)
     * @param  array             $cookies     The request cookies (key-value array)
     * @param  string            $bodyContent The request body
     * @param  ResponseInterface $response     The response object (optional)
     * @return ResponseInterface
     */
    public function subRequest(
        $method,
        $path,
        $query = '',
        array $headers = [],
        array $cookies = [],
        $bodyContent = '',
        ResponseInterface $response = null
    ) {
        $env = $this->container->get('environment');
        $uri = Uri::createFromEnvironment($env)->withPath($path)->withQuery($query);
        $headers = new Headers($headers);
        $serverParams = $env->all();
        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($bodyContent);
        $body->rewind();
        $request = new Request($method, $uri, $headers, $cookies, $serverParams, $body);

        if (!$response) {
            $response = $this->container->get('response');
        }

        return $this($request, $response);
    }

    /**
     * Dispatch the r to find the . Prepare the  for use.
     *
     * @param ServerRequestInterface $request
     * @param rInterface        $r
     * @return ServerRequestInterface
     */
    protected function dispatchrAndPrepare(ServerRequestInterface $request, rInterface $r)
    {
        $Info = $r->dispatch($request);

        if ($Info[0] === Dispatcher::FOUND) {
            $Arguments = [];
            foreach ($Info[2] as $k => $v) {
                $Arguments[$k] = urldecode($v);
            }

            $ = $r->lookup($Info[1]);
            $->prepare($request, $Arguments);

            // add  to the request's attributes in case a middleware or handler needs access to the
            $request = $request->withAttribute('', $);
        }

        $Info['request'] = [$request->getMethod(), (string) $request->getUri()];

        return $request->withAttribute('Info', $Info);
    }

    /**
     * Finalize response
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function finalize(ResponseInterface $response)
    {
        // stop PHP sending a Content-Type automatically
        ini_set('default_mimetype', '');

        if ($this->isEmptyResponse($response)) {
            return $response->withoutHeader('Content-Type')->withoutHeader('Content-Length');
        }

        // Add Content-Length header if `addContentLengthHeader` setting is set
        if (isset($this->container->get('settings')['addContentLengthHeader']) &&
            $this->container->get('settings')['addContentLengthHeader'] == true) {
            if (ob_get_length() > 0) {
                throw new \RuntimeException("Unexpected data in output buffer. " .
                    "Maybe you have characters before an opening <?php tag?");
            }
            $size = $response->getBody()->getSize();
            if ($size !== null && !$response->hasHeader('Content-Length')) {
                $response = $response->withHeader('Content-Length', (string) $size);
            }
        }

        return $response;
    }

    /**
     * Helper method, which returns true if the provided response must not output a body and false
     * if the response could have a body.
     *
     * @see https://tools.ietf.org/html/rfc7231
     *
     * @param ResponseInterface $response
     * @return bool
     */
    protected function isEmptyResponse(ResponseInterface $response)
    {
        if (method_exists($response, 'isEmpty')) {
            return $response->isEmpty();
        }

        return in_array($response->getStatusCode(), [204, 205, 304]);
    }

    /**
     * Call relevant handler from the Container if needed. If it doesn't exist,
     * then just re-throw.
     *
     * @param  Exception $e
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws Exception if a handler is needed and not found
     */
    protected function handleException(Exception $e, ServerRequestInterface $request, ResponseInterface $response)
    {
        if ($e instanceof MethodNotAllowedException) {
            $handler = 'notAllowedHandler';
            $params = [$e->getRequest(), $e->getResponse(), $e->getAllowedMethods()];
        } elseif ($e instanceof NotFoundException) {
            $handler = 'notFoundHandler';
            $params = [$e->getRequest(), $e->getResponse(), $e];
        } elseif ($e instanceof SlimException) {
            // This is a Stop exception and contains the response
            return $e->getResponse();
        } else {
            // Other exception, use $request and $response params
            $handler = 'errorHandler';
            $params = [$request, $response, $e];
        }

        if ($this->container->has($handler)) {
            $callable = $this->container->get($handler);
            // Call the registered handler
            return call_user_func_array($callable, $params);
        }

        // No handlers found, so just throw the exception
        throw $e;
    }

    /**
     * Call relevant handler from the Container if needed. If it doesn't exist,
     * then just re-throw.
     *
     * @param  Throwable $e
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function handlePhpError(Throwable $e, ServerRequestInterface $request, ResponseInterface $response)
    {
        $handler = 'phpErrorHandler';
        $params = [$request, $response, $e];

        if ($this->container->has($handler)) {
            $callable = $this->container->get($handler);
            // Call the registered handler
            return call_user_func_array($callable, $params);
        }

        // No handlers found, so just throw the exception
        throw $e;
    }
}
