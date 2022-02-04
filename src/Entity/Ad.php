<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Service\UploadHelper;

#[ORM\Entity(repositoryClass: AdRepository::class)]
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[NotBlank(message: 'Le champ de doit pas être vide')]
    private ?string $title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[NotBlank(message: 'Le champ de doit pas être vide')]
    private ?string $description;

    #[ORM\Column(type: 'float', nullable: true)]
    #[NotBlank(message: 'Le champ de doit pas être vide')]
    private ?float $price;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $created_at;

    #[ORM\ManyToOne(targetEntity: Tag::class, inversedBy: 'ads')]
    private ?Tag $tag;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ads')]
    private ?User $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imageFilename;

    #[ORM\OneToMany(mappedBy: 'ad', targetEntity: AdQuestion::class)]
    private ?Collection $adQuestions;

    #[ORM\OneToMany(mappedBy: 'ad', targetEntity: Vote::class)]
    private ?Collection $votes;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Tag|null
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag|null $tag
     * @return $this
     */
    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    #[Pure] public function getImagePath(): string
    {
        return $this->getImageFilename() ===
            '' ?
            UploadHelper::DEFAULT_IMAGE :
            UploadHelper::AD_IMAGE . '/' . $this->getImageFilename();
    }

    public function getAdQuestions(): Collection
    {
        return $this->adQuestions;
    }

    public function addAdQuestion(AdQuestion $adQuestion): self
    {
        if (!$this->adQuestions->contains($adQuestion)) {
            $this->adQuestions[] = $adQuestion;
            $adQuestion->setAd($this);
        }

        return $this;
    }

    public function removeAdQuestion(AdQuestion $adQuestion): self
    {
        if ($this->adQuestions->removeElement($adQuestion)) {
            if ($adQuestion->getAd() === $this) {
                $adQuestion->setAd(null);
            }
        }

        return $this;
    }

    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $adVote): self
    {
        // if (!$this->adQuestions->contains($adQuestion)) {
        //     $this->adQuestions[] = $adQuestion;
        //     $adQuestion->setAd($this);
        // }

        return $this;
    }

}
