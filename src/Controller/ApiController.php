<?php

declare(strict_types=1);

namespace App\Controller;

use App\Messanger\Bus\CommandBus;
use App\Messanger\Bus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiController extends AbstractController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
        protected SerializerInterface $serializer
    ) {}
}
