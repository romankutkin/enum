<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\NotUniqueValueException;
use App\Http\ApiResponse;
use App\Messanger\Message\Command\CreateUserCommand;
use App\Messanger\Message\Query\GetUserQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    #[Route('/api/users', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $command = $this->serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');

        try {
            $this->commandBus->dispatch($command);
        } catch (NotUniqueValueException $exception) {
            return ApiResponse::create(
                status: Response::HTTP_CONFLICT,
                content: [
                    'errors' => [
                        'detail' => $exception->getMessage(),
                    ],
                ],
            );
        }

        return ApiResponse::create(
            status: Response::HTTP_CREATED,
        );
    }

    #[Route('/api/users/{user}', methods: ['GET'])]
    public function show($user): Response
    {
        $query = new GetUserQuery($user);

        try {
            $user = $this->queryBus->dispatch($query);
        } catch (NotFoundException $exception) {
            return ApiResponse::create(
                status: Response::HTTP_NOT_FOUND,
                content: [
                    'errors' => [
                        'detail' => $exception->getMessage(),
                    ],
                ],
            );
        }

        return ApiResponse::create(
            status: Response::HTTP_OK,
            content: [
                'data' => [
                    'id' => $user->getUid(),
                    'attributes' => [
                        'username' => $user->getUsername(),
                    ],
                ],
            ],
        );
    }
}
