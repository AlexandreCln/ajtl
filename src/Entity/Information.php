<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InformationRepository")
 */
class Information
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
    private $presentationAbout;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentationGeneralInformation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentationAbout(): ?string
    {
        return $this->presentationAbout;
    }

    public function setPresentationAbout(?string $presentationAbout): self
    {
        $this->presentationAbout = $presentationAbout;

        return $this;
    }

    public function getPresentationGeneralInformation(): ?string
    {
        return $this->presentationGeneralInformation;
    }

    public function setPresentationGeneralInformation(?string $presentationGeneralInformation): self
    {
        $this->presentationGeneralInformation = $presentationGeneralInformation;

        return $this;
    }
}
