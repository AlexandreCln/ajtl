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
     * @ORM\ManyToMany(targetEntity="App\Entity\PresentationPerson")
     * @ORM\JoinTable(
     *      name="presentation_persons_mapping",
     *      joinColumns={@ORM\JoinColumn(name="presentation_person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="presentation_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $presentationPersons;

    public function __construct()
    {
        $this->presentationPersons = new ArrayCollection();
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
     * @return Collection|PresentationPerson[]
     */
    public function getPresentationPersons(): Collection
    {
        return $this->presentationPersons;
    }

    public function addPresentationPerson(PresentationPerson $presentationPerson): self
    {
        if (!$this->presentationPersons->contains($presentationPerson)) {
            $this->presentationPersons[] = $presentationPerson;
        }

        return $this;
    }

    public function removePresentationPerson(PresentationPerson $presentationPerson): self
    {
        if ($this->presentationPersons->contains($presentationPerson)) {
            $this->presentationPersons->removeElement($presentationPerson);
        }

        return $this;
    }
}
