<?php

declare(strict_types=1);

namespace App\Controller;

use App\Messanger\Bus\CommandBus;
use App\Messanger\Bus\QueryBus;
use App\Messanger\Message\Command\CreateUserCommand;
use App\Messanger\Message\Query\GetUserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
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
        } catch (HandlerFailedException $exception) {
            $exception = $exception->getPrevious();

            return new JsonResponse([
                'errors' => [
                    'detail' => $exception->getMessage(),
                ],
            ]);
        }

        return new JsonResponse();
    }

    #[Route('/api/users/{user}', methods: ['GET'])]
    public function show($user): JsonResponse
    {
        $user = $this->queryBus->dispatch(new GetUserQuery($user));

        return new JsonResponse([
            'data' => [
                'id' => $user[0]->getUid(),
                'attributes' => [
                    'username' => $user[0]->getUsername(),
                ],
            ],
        ]);
    }
}
