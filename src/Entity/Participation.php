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


    #[ORM\ManyToOne(inversedBy: 'participationsActivity')]
    private ?Activity $activity = null;

    /**
     * @var Collection<int, Nurse>
     */
    #[ORM\ManyToMany(targetEntity: Nurse::class, inversedBy: 'participationsNurses')]
    private Collection $possibleNurses;

    #[ORM\ManyToOne(inversedBy: 'participationsNurse')]
    private ?Nurse $confirmedNurse = null;

    #[ORM\ManyToOne(inversedBy: 'participationsAdminByPlace')]
    private ?Adminbyplace $adminByPlace = null;

    #[ORM\ManyToOne(inversedBy: 'participationsDonor')]
    private ?Donor $Donor = null;

    #[ORM\Column(nullable: true)]
    private ?bool $confirmedByNurse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $confirmedByAdmin = null;

    public function __construct()
    {
        $this->possibleNurses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonor(): Donor
    {
        return $this->Donor;
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




    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return Collection<int, Nurse>
     */
    public function getPossibleNurses(): Collection
    {
        return $this->possibleNurses;
    }

    public function addPossibleNurse(Nurse $possibleNurse): static
    {
        if (!$this->possibleNurses->contains($possibleNurse)) {
            $this->possibleNurses->add($possibleNurse);
        }

        return $this;
    }

    public function removePossibleNurse(Nurse $possibleNurse): static
    {
        $this->possibleNurses->removeElement($possibleNurse);

        return $this;
    }

    public function getConfirmedNurse(): ?Nurse
    {
        return $this->confirmedNurse;
    }

    public function setConfirmedNurse(?Nurse $confirmedNurse): static
    {
        $this->confirmedNurse = $confirmedNurse;

        return $this;
    }

    public function getAdminByPlace(): ?Adminbyplace
    {
        return $this->adminByPlace;
    }

    public function setAdminByPlace(?Adminbyplace $adminByPlace): static
    {
        $this->adminByPlace = $adminByPlace;

        return $this;
    }

    public function setDonor(?Donor $Donor): static
    {
        $this->Donor = $Donor;

        return $this;
    }

    public function isConfirmedByNurse(): ?bool
    {
        return $this->confirmedByNurse;
    }

    public function setConfirmedByNurse(?bool $confirmedByNurse): static
    {
        $this->confirmedByNurse = $confirmedByNurse;

        return $this;
    }

    public function isConfirmedByAdmin(): ?bool
    {
        return $this->confirmedByAdmin;
    }

    public function setConfirmedByAdmin(?bool $confirmedByAdmin): static
    {
        $this->confirmedByAdmin = $confirmedByAdmin;

        return $this;
    }
}
