<?php

declare(strict_types=1);

namespace App\Validator\Middleware;

use App\Validator\Exception\ConstraintViolationException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidatorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ValidatorInterface $validator
    ) {}

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $violations = $this->validator->validate($envelope->getMessage());

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
