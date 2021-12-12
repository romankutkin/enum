<?php

declare(strict_types=1);

namespace App\Messanger\Bus;

use App\Messanger\Message\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
