<?php

declare(strict_types=1);

namespace App\Messanger\Message\Command;

use App\Messanger\Message\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserCommand implements CommandInterface
{
    #[Assert\NotBlank(normalizer: 'trim')]
    private string $username;

    #[Assert\NotBlank(normalizer: 'trim')]
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}