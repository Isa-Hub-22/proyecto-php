<?php

namespace App\Entity;

use App\Repository\RickAndMortyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RickAndMortyRepository::class)]
class RickAndMorty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(nullable: true)]
    private ?int $codigo = null;

    #[ORM\ManyToMany(targetEntity: Status::class, inversedBy: 'rickandmortys')]
    private Collection $Statues;

    public function __construct()
    {
        $this->Statues = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(?int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getStatues(): Collection
    {
        return $this->Statues;
    }

    public function addStatue(Status $statue): self
    {
        if (!$this->Statues->contains($statue)) {
            $this->Statues->add($statue);
        }

        return $this;
    }

    public function removeStatue(Status $statue): self
    {
        $this->Statues->removeElement($statue);

        return $this;
    }
}
