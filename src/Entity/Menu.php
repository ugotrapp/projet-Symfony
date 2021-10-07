<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sauce;

    /**
     * @ORM\Column(type="array")
     */
    private $base = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $drink;

    /**
     * @ORM\Column(type="array")
     */
    private $extra = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSauce(): ?string
    {
        return $this->sauce;
    }

    public function setSauce(string $sauce): self
    {
        $this->sauce = $sauce;

        return $this;
    }

    public function getBase(): ?array
    {
        return $this->base;
    }

    public function setBase(array $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getDrink(): ?string
    {
        return $this->drink;
    }

    public function setDrink(string $drink): self
    {
        $this->drink = $drink;

        return $this;
    }

    public function getExtra(): ?array
    {
        return $this->extra;
    }

    public function setExtra(array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }
}
