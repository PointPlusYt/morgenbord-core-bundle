<?php

namespace Morgenbord\CoreBundle\Entity;

use Morgenbord\CoreBundle\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`user`")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['widget'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['widget'])]
    private ?string $username = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: UserWidget::class, orphanRemoval: true)]
    private Collection $userWidgets;

    public function __construct()
    {
        $this->userWidgets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

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
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * If you store any temporary, sensitive data on the user, clear it here
     * 
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // $this->password = null;
    }

    /**
     * @return Collection|UserWidget[]
     */
    public function getUserWidgets(): Collection
    {
        return $this->userWidgets;
    }

    public function addUserWidget(UserWidget $userWidget): self
    {
        if (!$this->userWidgets->contains($userWidget)) {
            $this->userWidgets[] = $userWidget;
            $userWidget->setOwner($this);
        }

        return $this;
    }

    public function removeUserWidget(UserWidget $userWidget): self
    {
        if ($this->userWidgets->removeElement($userWidget)) {
            // set the owning side to null (unless already changed)
            if ($userWidget->getOwner() === $this) {
                $userWidget->setOwner(null);
            }
        }

        return $this;
    }
}
