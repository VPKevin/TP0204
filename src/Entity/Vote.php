<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $positive;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    #[ORM\ManyToOne(targetEntity: Ad::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $ad_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositive(): ?bool
    {
        return $this->positive;
    }

    public function setPositive(bool $positive): self
    {
        $this->positive = $positive;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getAnswerId(): ?Answer
    {
        return $this->answer_id;
    }

    public function setAnswerId(?Answer $answer_id): self
    {
        $this->answer_id = $answer_id;

        return $this;
    }

    public function getAdId(): ?Ad
    {
        return $this->ad_id;
    }

    public function setAdId(?Ad $ad_id): self
    {
        $this->ad_id = $ad_id;

        return $this;
    }
}
