<?php

declare(strict_types=1);

namespace App\Messanger\Bus;

use App\Messanger\Message\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus,
    ) {
        $this->messageBus = $queryBus;
    }

    public function dispatch(QueryInterface $query): mixed
    {
        return $this->handle($query);
    }
}
