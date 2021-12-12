<?php

declare(strict_types=1);

namespace App\Controller;

use App\Messanger\Bus\CommandBus;
use App\Messanger\Message\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {}

    #[Route('/api/users', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $command = $serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');

        $this->commandBus->dispatch($command);

        return new JsonResponse();
    }
}
