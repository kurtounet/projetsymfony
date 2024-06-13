<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 15)]
    private ?string $ki = null;

    #[ORM\Column(length: 20)]
    private ?string $maxKi = null;

    #[ORM\Column(length: 20)]
    private ?string $race = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 20)]
    private ?string $affiliation = null;

    #[ORM\Column]
    private ?string $deletedAt = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::ARRAY , nullable: true)]
    private ?array $transformation = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?Planet $planet = null;

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

    public function getKi(): ?string
    {
        return $this->ki;
    }

    public function setKi(string $ki): static
    {
        $this->ki = $ki;

        return $this;
    }

    public function getMaxKi(): ?string
    {
        return $this->maxKi;
    }

    public function setMaxKi(string $maxKi): static
    {
        $this->maxKi = $maxKi;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(string $affiliation): static
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(string $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getTransformation(): ?array
    {
        return $this->transformation;
    }

    public function setTransformation(?array $transformation): static
    {
        $this->transformation = $transformation;

        return $this;
    }

    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    public function setPlanet(?Planet $planet): static
    {
        $this->planet = $planet;

        return $this;
    }
}
