<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresentationRepository")
 */
class Presentation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $aboutText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $generalText;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="presentatio")
     */
    private $coreUsers;

    public function __construct()
    {
        $this->coreUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAboutText(): ?string
    {
        return $this->aboutText;
    }

    public function setAboutText(?string $aboutText): self
    {
        $this->aboutText = $aboutText;

        return $this;
    }

    public function getGeneralText(): ?string
    {
        return $this->generalText;
    }

    public function setGeneralText(?string $generalText): self
    {
        $this->generalText = $generalText;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getCoreUsers(): Collection
    {
        return $this->coreUsers;
    }

    public function addCoreUser(User $coreUser): self
    {
        if (!$this->coreUsers->contains($coreUser)) {
            $this->coreUsers[] = $coreUser;
            $coreUser->setPresentatio($this);
        }

        return $this;
    }

    public function removeCoreUser(User $coreUser): self
    {
        if ($this->coreUsers->contains($coreUser)) {
            $this->coreUsers->removeElement($coreUser);
            // set the owning side to null (unless already changed)
            if ($coreUser->getPresentatio() === $this) {
                $coreUser->setPresentatio(null);
            }
        }

        return $this;
    }
}
