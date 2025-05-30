<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    #[ORM\Column(length: 255)]
    private ?string $folderImage = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\OneToOne(mappedBy: 'room', cascade: ['persist', 'remove'])]
    private ?Reservation $reservation = null;

    /**
     * @var Collection<int, Negociation>
     */
    #[ORM\OneToMany(targetEntity: Negociation::class, mappedBy: 'room', orphanRemoval: true)]
    private Collection $negociations;

    /**
     * @var Collection<int, Feature>
     */
    #[ORM\ManyToMany(targetEntity: Feature::class)]
    private Collection $features;

    #[ORM\Column(nullable: true)]
    private ?int $acceptanceThreshold = null;

    #[ORM\Column(nullable: true)]
    private ?int $refusalThreshold = null;

    #[ORM\Column(nullable: true)]
    private ?int $tradingThreshold = null;

    public function __construct()
    {
        $this->negociations = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getFolderImage(): ?string
    {
        return $this->folderImage;
    }

    public function setFolderImage(string $folderImage): static
    {
        $this->folderImage = $folderImage;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): static
    {
        // set the owning side of the relation if necessary
        if ($reservation->getRoom() !== $this) {
            $reservation->setRoom($this);
        }

        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection<int, Negociation>
     */
    public function getNegociations(): Collection
    {
        return $this->negociations;
    }

    public function addNegociation(Negociation $negociation): static
    {
        if (!$this->negociations->contains($negociation)) {
            $this->negociations->add($negociation);
            $negociation->setRoom($this);
        }

        return $this;
    }

    public function removeNegociation(Negociation $negociation): static
    {
        if ($this->negociations->removeElement($negociation)) {
            // set the owning side to null (unless already changed)
            if ($negociation->getRoom() === $this) {
                $negociation->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Feature>
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Feature $feature): static
    {
        if (!$this->features->contains($feature)) {
            $this->features->add($feature);
        }

        return $this;
    }

    public function removeFeature(Feature $feature): static
    {
        $this->features->removeElement($feature);

        return $this;
    }

    public function getAcceptanceThreshold(): ?int
    {
        return $this->acceptanceThreshold;
    }

    public function setAcceptanceThreshold(int $acceptanceThreshold): static
    {
        $this->acceptanceThreshold = $acceptanceThreshold;

        return $this;
    }

    public function getRefusalThreshold(): ?int
    {
        return $this->refusalThreshold;
    }

    public function setRefusalThreshold(int $refusalThreshold): static
    {
        $this->refusalThreshold = $refusalThreshold;

        return $this;
    }

    public function getTradingThreshold(): ?int
    {
        return $this->tradingThreshold;
    }

    public function setTradingThreshold(?int $tradingThreshold): static
    {
        $this->tradingThreshold = $tradingThreshold;

        return $this;
    }
}
