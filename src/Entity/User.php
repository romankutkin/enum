<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uid;

    #[ORM\Column(type: 'string', unique: true)]
    private string $username;

    /**
     * The hashed password.
     */
    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct(
        string $username,
        string $password,
    ) {
        $this->uid = Uuid::v4();
        $this->username = $username;
        $this->password = $password;
    }

    public function getUid(): Uuid
    {
        return $this->uid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // ...
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}
