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
use Lyssal\SimpleLocationBundle\Doctrine\Repository\LocationRepository;

#[ORM\MappedSuperclass(repositoryClass: LocationRepository::class)]
abstract class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 256, nullable: false)]
    protected string $name;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: LocationType::class)]
    protected LocationType $type;

    /**
     * @var Collection|Location[]
     */
    #[ORM\ManyToMany(targetEntity: LocationInterface::class, inversedBy: 'children')]
    #[ORM\JoinTable(name: 'location_location')]
    #[ORM\JoinColumn(name: 'location_source')]
    #[ORM\InverseJoinColumn(name: 'location_target')]
    protected Collection $parents;

    /**
     * @var Collection|Location[]
     */
    #[ORM\ManyToMany(targetEntity: LocationInterface::class, mappedBy: 'parents', cascade: ['persist'])]
    protected Collection $children;

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

    public function getType(): ?LocationType
    {
        return $this->type;
    }

    public function setType(?LocationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Location[]
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
     * @return Collection|Location[]
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
