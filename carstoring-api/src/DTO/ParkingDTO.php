<?php

namespace App\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParkingDTORepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ParkingDTORepository::class)
 */
class ParkingDTO
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
    public $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $localisation;

    /**
     * @ORM\Column(type="integer")
     */
    public $nbPlace;

    /**
     * @ORM\Column(type="integer")
     */
    public $placeHeight;

    /**
     * @ORM\Column(type="integer")
     */
    public $placeWidth;
}
