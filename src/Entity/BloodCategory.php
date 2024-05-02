<?php

namespace App\Entity;

use App\Repository\BloodCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Bloodhoster>
     */
    #[ORM\ManyToMany(targetEntity: Bloodhoster::class, mappedBy: 'blood_categ')]
    private Collection $bloodHosters;

    public function __construct()
    {
        $this->bloodHosters = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Bloodhoster>
     */
    public function getBloodHosters(): Collection
    {
        return $this->bloodHosters;
    }

    public function addBloodHoster(Bloodhoster $bloodHoster): static
    {
        if (!$this->bloodHosters->contains($bloodHoster)) {
            $this->bloodHosters->add($bloodHoster);
            $bloodHoster->addBloodCateg($this);
        }

        return $this;
    }

    public function removeBloodHoster(Bloodhoster $bloodHoster): static
    {
        if ($this->bloodHosters->removeElement($bloodHoster)) {
            $bloodHoster->removeBloodCateg($this);
        }

        return $this;
    }
}
