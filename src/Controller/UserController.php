<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\NotUniqueValueException;
use App\Messanger\Bus\CommandBus;
use App\Messanger\Bus\QueryBus;
use App\Messanger\Message\Command\CreateUserCommand;
use App\Messanger\Message\Query\GetUserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {}

    #[Route('/api/users', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $command = $serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');

        try {
            $this->commandBus->dispatch($command);
        } catch (NotUniqueValueException $exception) {
            return new JsonResponse([
                'errors' => [
                    'detail' => $exception->getMessage(),
                ],
            ], Response::HTTP_CONFLICT);
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    #[Route('/api/users/{user}', methods: ['GET'])]
    public function show($user): JsonResponse
    {
        try {
            $resource = $this->queryBus->dispatch(new GetUserQuery($user));
        } catch (NotFoundException $exception) {
            return new JsonResponse([
                'errors' => [
                    'detail' => $exception->getMessage(),
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'data' => [
                'id' => $resource->getUid(),
                'attributes' => [
                    'username' => $resource->getUsername(),
                ],
            ],
        ], Response::HTTP_OK);
    }
}
