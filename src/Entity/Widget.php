<?php

namespace Morgenbord\CoreBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\MappedSuperclass]
class Widget
{
    #[Groups(["widget"])]
    private $name;

    #[Groups(["widget"])]
    private $shortName;

    #[Groups(["widget"])]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private $parameterFormFqcn;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private $twigFile;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getParameterFormFqcn()
    {
        return $this->parameterFormFqcn;
    }

    /**
     * Returns the name of the bundle in the \@NameOfBundle format,
     * based on the FQCN
     *
     * @return string
     */
    public function getAtName(): string
    {
        return preg_replace('/(.+)\\\\(\w+)Parameters$/', '@${2}', $this->parameterFormFqcn);
    }

    public function setParameterFormFqcn($fqcn)
    {
        $this->parameterFormFqcn = $fqcn;

        return $this;
    }

    public function getTwigFile(): ?string
    {
        return $this->twigFile;
    }

    public function setTwigFile(string $twigFile): self
    {
        $this->twigFile = $twigFile;

        return $this;
    }
}