<?php

declare(strict_types=1);

namespace App\Messanger\Bus;

use App\Messanger\Message\QueryInterface;

interface QueryBusInterface
{
    public function dispatch(QueryInterface $query): mixed;
}
