<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Twig\Environment;

class ErrorHandlingMiddleware
{
private $twig;

public function __construct(Environment $twig)
{
$this->twig = $twig;
}

public function onKernelException(ExceptionEvent $event)
{
$exception = $event->getThrowable();
$request = $event->getRequest();

// Default response
$response = new Response();

// Check if the exception is an instance of HttpExceptionInterface
if ($exception instanceof HttpExceptionInterface) {
// Customize response based on the exception
$statusCode = $exception->getStatusCode();
$response->setStatusCode($statusCode);
$content = $this->twig->render('errors/error'.$statusCode.'.html.twig');
$response->setContent($content);
} else {
// Generic error handling
$response->setContent($this->twig->render('errors/error500.html.twig'));
$response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
}

// Send the response to the client
$event->setResponse($response);
}
}