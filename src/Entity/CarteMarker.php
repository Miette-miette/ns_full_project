<?php

namespace App\Entity;

use App\Repository\CarteMarkerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteMarkerRepository::class)]
class CarteMarker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $lat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $lng = null;

    #[ORM\Column(length: 250)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $icon;

    #[ORM\Column(nullable: true)]
    private ?int $iconSize = null;

    #[ORM\Column(nullable: true)]
    private ?int $iconAnchor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(string $lng): static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIconSize(): ?int
    {
        return $this->iconSize;
    }

    public function setIconSize(?int $iconSize): static
    {
        $this->iconSize = $iconSize;

        return $this;
    }

    public function getIconAnchor(): ?int
    {
        return $this->iconAnchor;
    }

    public function setIconAnchor(?int $iconAnchor): static
    {
        $this->iconAnchor = $iconAnchor;

        return $this;
    }
}
