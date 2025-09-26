<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'Image', cascade: ['persist', 'remove'])]
    private ?Burger $burger = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): static
    {
        // unset the owning side of the relation if necessary
        if ($burger === null && $this->burger !== null) {
            $this->burger->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($burger !== null && $burger->getImage() !== $this) {
            $burger->setImage($this);
        }

        $this->burger = $burger;

        return $this;
    }
}
