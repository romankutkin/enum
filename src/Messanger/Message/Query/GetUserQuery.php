<?php

declare(strict_types=1);

namespace App\Messanger\Message\Query;

use App\Messanger\Message\QueryInterface;

class GetUserQuery implements QueryInterface
{
    public function __construct(
        private string $uid
    ) {}

    public function getUid(): string
    {
        return $this->uid;
    }
}
