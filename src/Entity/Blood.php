<?php

namespace App\Entity;

use App\Repository\BloodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BloodRepository::class)]
class Blood
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity_blood = null;

    #[ORM\Column(length: 60)]
    private ?string $number_donors = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityBlood(): ?int
    {
        return $this->quantity_blood;
    }

    public function setQuantityBlood(int $quantity_blood): static
    {
        $this->quantity_blood = $quantity_blood;

        return $this;
    }

    public function getNumberDonors(): ?string
    {
        return $this->number_donors;
    }

    public function setNumberDonors(string $number_donors): static
    {
        $this->number_donors = $number_donors;

        return $this;
    }
}
