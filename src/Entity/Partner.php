<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartnerRepository")
 * @Vich\Uploadable()
 */
class Partner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Ce champ ne doit pas être vide.")
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message = "Ce champ ne doit pas être vide.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Ce lien ne peut pas faire plus de {{ limit }} caractères."
     * )
     */
    private $link;

    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes={
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *      }
     * )
     * @Assert\File(
     *     maxSize="1M",
     * )
     * @Vich\UploadableField(mapping="partner_file", fileNameProperty="filenamePartner")
     */
    private $partnerFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $filenamePartner;

    /**
     * @return File|null
     */
    public function getPartnerFile(): ?File
    {
        return $this->partnerFile;
    }

    /**
     * @param File|null $partnerFile
     * @return Partner
     * @throws Exception
     */
    public function setPartnerFile(?File $partnerFile): Partner
    {
        $this->partnerFile = $partnerFile;

        if ($this->partnerFile instanceof UploadedFile) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilenamePartner(): ?string
    {
        return $this->filenamePartner;
    }

    /**
     * @param string|null $filenamePartner
     * @return Partner
     */
    public function setFilenamePartner(?string $filenamePartner): Partner
    {
        $this->filenamePartner = $filenamePartner;
        return $this;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
