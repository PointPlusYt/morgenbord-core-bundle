<?php

namespace Morgenbord\CoreBundle\Entity;

use Morgenbord\CoreBundle\Repository\UserWidgetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserWidgetRepository::class)]
class UserWidget extends Widget
{
    #[Groups(["widget"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["widget"])]
    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"userWidgets")]
    #[ORM\JoinColumn(nullable:false)]
    private $owner;

    #[Groups(["widget"])]
    #[ORM\Column(type: 'json')]
    private $parameters;

    #[ORM\Column(type: 'json', nullable: true)]
    private $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
