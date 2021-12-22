<?php

declare(strict_types=1);

namespace App\Validator\Listener;

use App\Http\ApiResponse;
use App\Validator\Exception\ConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ConstraintViolationListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ConstraintViolationException) {
            $this->handleConstraintViolationException($event, $exception);
        }
    }

    private function handleConstraintViolationException(ExceptionEvent $event, ConstraintViolationException $exception): void
    {
        $violations = $exception->getConstraintViolations();
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'code' => $violation->getCode(),
                'source' => [
                    'pointer' => '/data/attributes/' . $violation->getPropertyPath(),
                ],
                'detail' => $violation->getMessage(),
            ];
        }

        $event->setResponse(ApiResponse::create(
            status: Response::HTTP_BAD_REQUEST,
            content: [
                'errors' => $errors,
            ],
        ));
    }
}
