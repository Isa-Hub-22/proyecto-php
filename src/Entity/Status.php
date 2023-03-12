<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToMany(targetEntity: RickAndMorty::class, mappedBy: 'Statues')]
    private Collection $rickandmortys;

    public function __construct()
    {
        $this->rickandmortys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, RickAndMorty>
     */
    public function getRickandmortys(): Collection
    {
        return $this->rickandmortys;
    }

    public function addRickandmorty(RickAndMorty $rickandmorty): self
    {
        if (!$this->rickandmortys->contains($rickandmorty)) {
            $this->rickandmortys->add($rickandmorty);
            $rickandmorty->addStatue($this);
        }

        return $this;
    }

    public function removeRickandmorty(RickAndMorty $rickandmorty): self
    {
        if ($this->rickandmortys->removeElement($rickandmorty)) {
            $rickandmorty->removeStatue($this);
        }

        return $this;
    }
}
