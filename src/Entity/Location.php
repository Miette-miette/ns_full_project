<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[UniqueEntity('name')]
#[Vich\Uploadable]
class Location
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

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $type_de_lieu = null;

    #[ORM\Column(nullable: true)]
    private ?int $iconSize = null;

    #[ORM\Column(nullable: true)]
    private ?int $iconAnchor = null;

    #[ORM\Column(length: 6000, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $begin_datetime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_datetime = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'ns_img', fileNameProperty: 'imageName' )]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $img = null;

    /*#[ORM\Column(nullable: true)]
    private ?string $icon = null;*/

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    //FOREIGN KEY

    /**
     * @var Collection<int, Atelier>
     */
    #[ORM\OneToMany(targetEntity: Atelier::class, mappedBy: 'Location')]
    private Collection $ateliers;

    /**
     * @var Collection<int, Concert>
     */
    #[ORM\OneToMany(targetEntity: Concert::class, mappedBy: 'Location')]
    private Collection $concerts;

    /**
     * @var Collection<int, Performance>
     */
    #[ORM\OneToMany(targetEntity: Performance::class, mappedBy: 'location')]
    private Collection $performances;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->concerts = new ArrayCollection();
        $this->performances = new ArrayCollection();
    }



    //GETTER ET SETTER

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

    /*public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): static
    {
        $this->icon = $icon;

        return $this;
    }*/

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getBeginDatetime(): ?\DateTimeInterface
    {
        return $this->begin_datetime;
    }

    public function setBeginDatetime(?\DateTimeInterface $begin_datetime): static
    {
        $this->begin_datetime = $begin_datetime;

        return $this;
    }

    public function getEndDatetime(): ?\DateTimeInterface
    {
        return $this->end_datetime;
    }

    public function setEndDatetime(?\DateTimeInterface $end_datetime): static
    {
        $this->end_datetime = $end_datetime;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $img): void
    {
        $this->img = $img; //|| $this->icon =$icon;
    }

    public function getImageName(): ?string
    {
        return $this->img; //|| $this->icon;
    }

    public function getTypeDeLieu(): ?string
    {
        return $this->type_de_lieu;
    }

    public function setTypeDeLieu(?string $type_de_lieu): static
    {
        $this->type_de_lieu = $type_de_lieu;

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): static
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
            $atelier->setLocation($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): static
    {
        if ($this->ateliers->removeElement($atelier)) {
            // set the owning side to null (unless already changed)
            if ($atelier->getLocation() === $this) {
                $atelier->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): static
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->setLocation($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): static
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getLocation() === $this) {
                $concert->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Performance>
     */
    public function getPerformances(): Collection
    {
        return $this->performances;
    }

    public function addPerformance(Performance $performance): static
    {
        if (!$this->performances->contains($performance)) {
            $this->performances->add($performance);
            $performance->setLocation($this);
        }

        return $this;
    }

    public function removePerformance(Performance $performance): static
    {
        if ($this->performances->removeElement($performance)) {
            // set the owning side to null (unless already changed)
            if ($performance->getLocation() === $this) {
                $performance->setLocation(null);
            }
        }

        return $this;
    }
}
