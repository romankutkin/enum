<?php

declare(strict_types=1);

namespace App\Messanger\Handler\Query;

use App\Entity\User;
use App\Exception\NotFoundException;
use App\Messanger\Handler\QueryHandlerInterface;
use App\Messanger\Message\Query\GetUserQuery;
use Doctrine\ORM\EntityManagerInterface;

class GetUserHandler implements QueryHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(GetUserQuery $query): User
    {
        $repository = $this->entityManager->getRepository(User::class);

        $user = $repository->findOneBy([
            'uid' => $query->getUid(),
        ]);

        if (!$user) {
            throw new NotFoundException(
                sprintf("User with uid '%s' not found.", $query->getUid())
            );
        }

        return $user;
    }
}
