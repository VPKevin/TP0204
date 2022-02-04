<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $label;

    #[ORM\OneToOne(inversedBy: 'answer', targetEntity: AdQuestion::class, cascade: ['persist', 'remove'])]
    private ?AdQuestion $AdQuestion;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'answers')]
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getAdQuestion(): ?AdQuestion
    {
        return $this->AdQuestion;
    }

    public function setAdQuestion(?AdQuestion $AdQuestion): self
    {
        $this->AdQuestion = $AdQuestion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
