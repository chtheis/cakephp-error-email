<?php
namespace ErrorEmail\Middleware;

use Cake\Error\Middleware\ErrorHandlerMiddleware as CakeErrorHandlerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ErrorEmail\Traits\EmailThrowableTrait;
use Throwable;

/**
 * Error handling middleware.
 *
 * Extends cake's error handling middleware and adds emailing functionality to it.
 */
class ErrorHandlerMiddleware extends CakeErrorHandlerMiddleware
{
    use EmailThrowableTrait;

    /**
     * Add email funcitonality to handle exception
     *
     * @param \Exception $exception The exception to handle.
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    public function handleException(Throwable $exception, ServerRequestInterface $request): ResponseInterface
    {
        // Add emailing throwable functionality
        $this->emailThrowable($exception);
        // Use parent funcitonality
        return $this->_callParent($exception, $request);
    }

    /**
     * Wrap parent functionality so we can isolate our class for testing
     *
     * @param \Exception $exception The exception to handle.
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    protected function _callParent($exception, $request)
    {
        return parent::handleException($exception, $request);
    }
}
