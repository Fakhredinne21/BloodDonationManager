<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ParticipationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
#[ApiResource]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    /**
     * @var Collection<int, Donor>
     */
    #[ORM\OneToMany(targetEntity: Donor::class, mappedBy: 'participation')]
    private Collection $donor;

    #[ORM\ManyToOne(inversedBy: 'participations')]
    private ?Activity $activities = null;

    #[ORM\Column]
    private ?bool $approved = null;

    /**
     * @var Collection<int, Nurse>
     */
    #[ORM\ManyToMany(targetEntity: Nurse::class, inversedBy: 'participations')]
    private Collection $nurse;

    #[ORM\Column(nullable: true)]
    private ?bool $approvedByNurse = null;

    public function __construct()
    {
        $this->donor = new ArrayCollection();
        $this->nurse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Donor>
     */
    public function getDonor(): Collection
    {
        return $this->donor;
    }

    public function addDonor(Donor $donor): static
    {
        if (!$this->donor->contains($donor)) {
            $this->donor->add($donor);
            $donor->setParticipation($this);
        }

        return $this;
    }

    public function removeDonor(Donor $donor): static
    {
        if ($this->donor->removeElement($donor)) {
            // set the owning side to null (unless already changed)
            if ($donor->getParticipation() === $this) {
                $donor->setParticipation(null);
            }
        }

        return $this;
    }

    public function getActivities(): ?Activity
    {
        return $this->activities;
    }

    public function setActivities(?Activity $activities): static
    {
        $this->activities = $activities;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): static
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * @return Collection<int, Nurse>
     */
    public function getNurse(): Collection
    {
        return $this->nurse;
    }

    public function addNurse(Nurse $nurse): static
    {
        if (!$this->nurse->contains($nurse)) {
            $this->nurse->add($nurse);
        }

        return $this;
    }

    public function removeNurse(Nurse $nurse): static
    {
        $this->nurse->removeElement($nurse);

        return $this;
    }

    public function isApprovedByNurse(): ?bool
    {
        return $this->approvedByNurse;
    }

    public function setApprovedByNurse(?bool $approvedByNurse): static
    {
        $this->approvedByNurse = $approvedByNurse;

        return $this;
    }
}
