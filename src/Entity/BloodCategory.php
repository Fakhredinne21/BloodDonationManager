<?php

namespace App\Entity;

use App\Repository\BloodCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BloodCategoryRepository::class)]
class BloodCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $categ_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategName(): ?string
    {
        return $this->categ_name;
    }

    public function setCategName(string $categ_name): static
    {
        $this->categ_name = $categ_name;

        return $this;
    }
}
