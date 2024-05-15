<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $nameActivity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Donor>
     */
    #[ORM\ManyToMany(targetEntity: Donor::class, inversedBy: 'participations')]
    private Collection $donors;

    public function __construct()
    {
        $this->donors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getNameActivity(): ?string
    {
        return $this->nameActivity;
    }

    public function setNameActivity(string $nameActivity): static
    {
        $this->nameActivity = $nameActivity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Donor>
     */
    public function getDonors(): Collection
    {
        return $this->donors;
    }

    public function addDonor(Donor $donor): static
    {
        if (!$this->donors->contains($donor)) {
            $this->donors->add($donor);
        }

        return $this;
    }

    public function removeDonor(Donor $donor): static
    {
        $this->donors->removeElement($donor);

        return $this;
    }
}
