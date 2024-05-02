<?php

namespace App\Entity;

use App\Repository\DonorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonorRepository::class)]
class Donor extends User
{

    #[ORM\Column]
    private ?int $state = null;

    /**
     * @var Collection<int, BloodHoster>
     */
    #[ORM\ManyToMany(targetEntity: BloodHoster::class, inversedBy: 'donors')]
    private Collection $id;

    public function __construct()
    {
        $this->id = new ArrayCollection();
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, BloodHoster>
     */
    public function getId(): Collection
    {
        return $this->id;
    }

    public function addId(BloodHoster $id): static
    {
        if (!$this->id->contains($id)) {
            $this->id->add($id);
        }

        return $this;
    }

    public function removeId(BloodHoster $id): static
    {
        $this->id->removeElement($id);

        return $this;
    }
}
