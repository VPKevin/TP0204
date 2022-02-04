<?php

namespace App\Entity;

use App\Repository\AdQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdQuestionRepository::class)]
class AdQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $created_at;

    #[ORM\ManyToOne(targetEntity: Ad::class, inversedBy: 'adQuestions')]
    private ?Ad $ad;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'adQuestions')]
    private ?User $user;

    #[ORM\OneToOne(mappedBy: 'AdQuestion', targetEntity: Answer::class, cascade: ['persist', 'remove'])]
    private ?Answer $answer;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

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

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        // unset the owning side of the relation if necessary
        if ($answer === null && $this->answer !== null) {
            $this->answer->setAdQuestion(null);
        }

        // set the owning side of the relation if necessary
        if ($answer !== null && $answer->getAdQuestion() !== $this) {
            $answer->setAdQuestion($this);
        }

        $this->answer = $answer;

        return $this;
    }
}
