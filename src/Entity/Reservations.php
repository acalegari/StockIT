<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startReservationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endReservationDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStartReservationDate(): ?\DateTimeInterface
    {
        return $this->startReservationDate;
    }

    public function setStartReservationDate(\DateTimeInterface $startReservationDate): self
    {
        $this->startReservationDate = $startReservationDate;

        return $this;
    }

    public function getEndReservationDate(): ?\DateTimeInterface
    {
        return $this->endReservationDate;
    }

    public function setEndReservationDate(\DateTimeInterface $endReservationDate): self
    {
        $this->endReservationDate = $endReservationDate;

        return $this;
    }

}
