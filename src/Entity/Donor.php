<?php

namespace App\Entity;

use App\Repository\DonorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonorRepository::class)]
class Donor extends User
{

    #[ORM\Column]
    private ?int $state = null;

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): static
    {
        $this->state = $state;

        return $this;
    }
}
