<?php

namespace App\Entity;

use App\Repository\RoomRepository;
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

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\ManyToOne(inversedBy: Establishment::class, targetEntity: Establishment::class)]
    private Establishment $establishment;

    #[ORM\OneToMany(mappedBy: Room::class, targetEntity: Event::class)]
    private Event $event;

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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getEstablishment(): ?Establishment{
        return $this->establishment;
    }

    public function setEstablishment(Establishment $establishment): static
    {
        $this->establishment = $establishment;
        return $this;
    }

    public function getEvent(): ?Event{
        return $this->event;
    }
}
