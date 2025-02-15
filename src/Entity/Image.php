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
    private ?string $path = null;

    //Relation Image
    #[ORM\ManyToOne(targetEntity: Room::class, inversedBy: "images")]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Room $room = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getFilename(): string{
        $exploded = explode('/', $this->path);

        return end($exploded);
    }
    public function getRoom(): ?Room{
        return $this->room;
    }
    public function setRoom(Room $room): static
    {
        $this->room = $room;
        return $this;
    }
}
