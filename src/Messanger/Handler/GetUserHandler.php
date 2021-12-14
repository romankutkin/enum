<?php

declare(strict_types=1);

namespace App\Messanger\Handler;

use App\Entity\User;
use App\Messanger\Message\Query\GetUserQuery;
use Doctrine\ORM\EntityManagerInterface;

class GetUserHandler implements QueryHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(GetUserQuery $query)
    {
        $repository = $this->entityManager->getRepository(User::class);

        return $repository->findOneBy([
            'uid' => $query->getUid(),
        ]);
    }
}
