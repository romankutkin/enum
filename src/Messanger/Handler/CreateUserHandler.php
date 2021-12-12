<?php

declare(strict_types=1);

namespace App\Messanger\Handler;

use App\Entity\User;
use App\Messanger\Message\CreateUserCommand;
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
