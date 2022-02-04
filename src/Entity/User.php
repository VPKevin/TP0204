<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
  fields: ['email'],
  message: 'Il existe déjà un compte avec cet email',
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $pseudo;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ad::class)]
    private ?Collection $adQuestions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ad::class)]
    private ?Collection $answers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ad::class)]
    private Collection $ads;

    #[Pure] public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->adQuestions = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAdQuestion(): ?Collection
    {
        return $this->adQuestions;
    }

    public function addAdQuestions(AdQuestion $adQuestion): self
    {
        if (!$this->adQuestions->contains($adQuestion)) {
            $this->adQuestions[] = $adQuestion;
            $adQuestion->setUser($this);
        }

        return $this;
    }

    public function removeAdQuestions(AdQuestion $adQuestion): self
    {
        if ($this->adQuestions->removeElement($adQuestion)) {
            if ($adQuestion->getUser() === $this) {
                $adQuestion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setUser($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->removeElement($ad)) {
            if ($ad->getUser() === $this) {
                $ad->setUser(null);
            }
        }

        return $this;
    }

    public function getAnswers(): ?Collection
    {
        return $this->answers;
    }



    public function addAnswers(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswers(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }
}
