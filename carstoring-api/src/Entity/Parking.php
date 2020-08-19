<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ParkingRepository::class)
 */
class Parking
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="parking")
     */
    private $cars;

    /**
     * @ORM\OneToMany(targetEntity=ParkingSpace::class, mappedBy="parking", orphanRemoval=true)
     */
    private $parkingSpace;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->parkingSpace = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setParking($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->contains($car)) {
            $this->cars->removeElement($car);
            // set the owning side to null (unless already changed)
            if ($car->getParking() === $this) {
                $car->setParking(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ParkingSpace[]
     */
    public function getParkingSpace(): Collection
    {
        return $this->parkingSpace;
    }

    public function addParkingSpace(ParkingSpace $parkingSpace): self
    {
        if (!$this->parkingSpace->contains($parkingSpace)) {
            $this->parkingSpace[] = $parkingSpace;
            $parkingSpace->setParking($this);
        }

        return $this;
    }

    public function removeParkingSpace(ParkingSpace $parkingSpace): self
    {
        if ($this->parkingSpace->contains($parkingSpace)) {
            $this->parkingSpace->removeElement($parkingSpace);
            // set the owning side to null (unless already changed)
            if ($parkingSpace->getParking() === $this) {
                $parkingSpace->setParking(null);
            }
        }

        return $this;
    }
}
