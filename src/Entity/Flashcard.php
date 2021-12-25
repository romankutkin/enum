<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'flashcards')]
class Flashcard
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uid;

    #[ORM\Column(type: 'string')]
    private string $question;

    #[ORM\Column(type: 'string')]
    private string $answer;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $author;

    public function __construct(
        string $question,
        string $answer,
        User $author,
    ) {
        $this->uid = Uuid::v4();
        $this->question = $question;
        $this->answer = $answer;
        $this->author = $author;
    }

    public function getUid(): Uuid
    {
        return $this->uid;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}
