<?php

declare(strict_types=1);

namespace App\Messanger\Bus;

use App\Messanger\Message\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus
{
    public function __construct(
        private MessageBusInterface $commandBus,
    ) {}

    public function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
