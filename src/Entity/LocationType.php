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
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \Lyssal\SimpleLocationBundle\Doctrine\Repository\LocationTypeRepository::class)]
class LocationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'smallint')]
    private int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $name;

    /**
     * @var \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\LocationType[]
     */
    #[ORM\ManyToMany(targetEntity: LocationType::class, inversedBy: 'children')]
    private Collection $parents;

    /**
     * @var \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\LocationType[]
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
     * @return \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\LocationType[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
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
     * @return \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\LocationType[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $child->addParent($this);
            $this->children[] = $child;
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
