<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterThemeRepository")
 */
class NewsletterTheme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NewsletterSubscriber", mappedBy="newsletterThemes")
     */
    private $newsletterSubscribers;

    public function __construct()
    {
        $this->newsletterSubscribers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|NewsletterSubscriber[]
     */
    public function getNewsletterSubscribers(): Collection
    {
        return $this->newsletterSubscribers;
    }

    public function addNewsletterSubscriber(NewsletterSubscriber $newsletterSubscriber): self
    {
        if (!$this->newsletterSubscribers->contains($newsletterSubscriber)) {
            $this->newsletterSubscribers[] = $newsletterSubscriber;
            $newsletterSubscriber->addNewsletterTheme($this);
        }

        return $this;
    }

    public function removeNewsletterSubscriber(NewsletterSubscriber $newsletterSubscriber): self
    {
        if ($this->newsletterSubscribers->contains($newsletterSubscriber)) {
            $this->newsletterSubscribers->removeElement($newsletterSubscriber);
            $newsletterSubscriber->removeNewsletterTheme($this);
        }

        return $this;
    }
}
