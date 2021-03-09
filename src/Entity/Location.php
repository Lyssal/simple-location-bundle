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

/**
 * @ORM\MappedSuperclass(repositoryClass="Lyssal\SimpleLocationBundle\Doctrine\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    protected $name;

    /**
     * @var \Lyssal\SimpleLocationBundle\Entity\LocationType
     *
     * @ORM\ManyToOne (targetEntity="Lyssal\SimpleLocationBundle\Entity\LocationType")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $type;

    /**
     * @var \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\Location[]
     *
     * @ORM\ManyToMany(targetEntity="Location", inversedBy="children")
     */
    protected $parents;

    /**
     * @var \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\Location[]
     *
     * @ORM\ManyToMany(targetEntity="Location", mappedBy="parents", cascade="persist")
     */
    protected $children;

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
     * @return \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\Location[]
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
     * @return \Doctrine\Common\Collections\Collection|\Lyssal\SimpleLocationBundle\Entity\Location[]
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
