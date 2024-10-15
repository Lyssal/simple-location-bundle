<?php

/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */

namespace Lyssal\SimpleLocationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Lyssal\SimpleLocationBundle\Doctrine\Repository\LocationTypeRepository;

#[ORM\Entity(repositoryClass: LocationTypeRepository::class)]
class LocationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private string $name;

    /**
     * @var Collection|LocationType[]
     */
    #[ORM\ManyToMany(targetEntity: LocationType::class, inversedBy: 'children')]
    private Collection $parents;

    /**
     * @var Collection|LocationType[]
     */
    #[ORM\ManyToMany(targetEntity: LocationType::class, mappedBy: 'parents')]
    private Collection $children;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|LocationType[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parents->contains($parent)) {
            $this->parents->removeElement($parent);
        }

        return $this;
    }

    /**
     * @return Collection|LocationType[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $child->addParent($this);
            $this->children->add($child);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->contains($child)) {
            $child->removeParent($this);
            $this->children->removeElement($child);
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
