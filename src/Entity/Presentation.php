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
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     * @ORM\JoinTable(
     *      name="presentation_users",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="presentation_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $presentationUsers;

    public function __construct()
    {
        $this->presentationUsers = new ArrayCollection();
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
    public function getPresentationUsers(): Collection
    {
        return $this->presentationUsers;
    }

    public function addPresentationUser(User $user): self
    {
        if (!$this->presentationUsers->contains($user)) {
            $this->presentationUsers[] = $user;
        }

        return $this;
    }

    public function removePresentationUser(User $user): self
    {
        if ($this->presentationUsers->contains($user)) {
            $this->presentationUsers->removeElement($user);
        }

        return $this;
    }
}
