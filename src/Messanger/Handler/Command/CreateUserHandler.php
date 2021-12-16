<?php

declare(strict_types=1);

namespace App\Messanger\Handler\Command;

use App\Entity\User;
use App\Messanger\Handler\CommandHandlerInterface;
use App\Messanger\Message\Command\CreateUserCommand;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User(
            username: $command->getUsername(),
            password: $command->getPassword(),
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
