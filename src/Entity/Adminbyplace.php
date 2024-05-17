<?php

namespace App\Entity;

use App\Repository\AdminbyplaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminbyplaceRepository::class)]
class Adminbyplace extends Users
{
    /**
     * @var Collection<int, Activity>
     */
    #[ORM\OneToMany(targetEntity: Activity::class, mappedBy: 'adminbyplace')]
    private Collection $activities;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'adminByPlace')]
    private Collection $participationsAdminByPlace;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->participationsAdminByPlace = new ArrayCollection();
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setAdminbyplace($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getAdminbyplace() === $this) {
                $activity->setAdminbyplace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipationsAdminByPlace(): Collection
    {
        return $this->participationsAdminByPlace;
    }

    public function addParticipationsAdminByPlace(Participation $participationsAdminByPlace): static
    {
        if (!$this->participationsAdminByPlace->contains($participationsAdminByPlace)) {
            $this->participationsAdminByPlace->add($participationsAdminByPlace);
            $participationsAdminByPlace->setAdminByPlace($this);
        }

        return $this;
    }

    public function removeParticipationsAdminByPlace(Participation $participationsAdminByPlace): static
    {
        if ($this->participationsAdminByPlace->removeElement($participationsAdminByPlace)) {
            // set the owning side to null (unless already changed)
            if ($participationsAdminByPlace->getAdminByPlace() === $this) {
                $participationsAdminByPlace->setAdminByPlace(null);
            }
        }

        return $this;
    }
}
