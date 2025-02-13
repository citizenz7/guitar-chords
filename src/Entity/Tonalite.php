<?php

namespace App\Entity;

use App\Repository\TonaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TonaliteRepository::class)]
class Tonalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Chord>
     */
    #[ORM\OneToMany(targetEntity: Chord::class, mappedBy: 'tonalite', orphanRemoval: true)]
    private Collection $chords;

    public function __construct()
    {
        $this->chords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Chord>
     */
    public function getChords(): Collection
    {
        return $this->chords;
    }

    public function addChord(Chord $chord): static
    {
        if (!$this->chords->contains($chord)) {
            $this->chords->add($chord);
            $chord->setTonalite($this);
        }

        return $this;
    }

    public function removeChord(Chord $chord): static
    {
        if ($this->chords->removeElement($chord)) {
            // set the owning side to null (unless already changed)
            if ($chord->getTonalite() === $this) {
                $chord->setTonalite(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
