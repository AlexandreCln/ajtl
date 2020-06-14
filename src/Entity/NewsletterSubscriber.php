<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterSubscriberRepository")
 */
class NewsletterSubscriber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NewsletterTheme", inversedBy="newsletterSubscribers")
     */
    private $newsletterThemes;

    public function __construct()
    {
        $this->newsletterThemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|NewsletterTheme[]
     */
    public function getNewsletterThemes(): Collection
    {
        return $this->newsletterThemes;
    }

    public function addNewsletterTheme(NewsletterTheme $newsletterTheme): self
    {
        if (!$this->newsletterThemes->contains($newsletterTheme)) {
            $this->newsletterThemes[] = $newsletterTheme;
        }

        return $this;
    }

    public function removeNewsletterTheme(NewsletterTheme $newsletterTheme): self
    {
        if ($this->newsletterThemes->contains($newsletterTheme)) {
            $this->newsletterThemes->removeElement($newsletterTheme);
        }

        return $this;
    }
}
