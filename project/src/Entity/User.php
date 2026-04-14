<?php

namespace App\Entity;


use App\Repository\UserRepository;
use App\Enum\RoleEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(type: "smallint", enumType: RoleEnum::class)]
    private RoleEnum $role;

    /**
     * @var Collection<int, Notice>
     */
    #[ORM\OneToMany(targetEntity: Notice::class, mappedBy: 'author')]
    private Collection $notices;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRole(): ?RoleEnum
    {
        return $this->role;
    }

    public function setRole(RoleEnum $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->notices = new ArrayCollection();
    }

    /**
     * @return Collection<int, Notice>
     */
    public function getNotices(): Collection
    {
        return $this->notices;
    }

    public function addNotice(Notice $notice): static
    {
        if (!$this->notices->contains($notice)) {
            $this->notices->add($notice);
            $notice->setAuthor($this);
        }

        return $this;
    }

    public function removeNotice(Notice $notice): static
    {
        if ($this->notices->removeElement($notice)) {
            // set the owning side to null (unless already changed)
            if ($notice->getAuthor() === $this) {
                $notice->setAuthor(null);
            }
        }

        return $this;
    }
}
