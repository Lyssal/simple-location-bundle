<?php

/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */

namespace Lyssal\SimpleLocationBundle\Entity;

use Doctrine\Common\Collections\Collection;

interface LocationInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(?string $name): self;

    public function getType(): ?LocationType;

    public function setType(?LocationType $type): self;

    /**
     * @return Collection|self[]
     */
    public function getParents(): Collection;

    public function addParent(self $parent): self;

    public function removeParent(self $parent): self;

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection;

    public function addChild(self $child): self;

    public function removeChild(self $child): self;
}
