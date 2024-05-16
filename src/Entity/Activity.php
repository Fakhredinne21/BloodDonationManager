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

    /**
     * @var Collection<int, Nurse>
     */
    #[ORM\ManyToMany(targetEntity: Nurse::class, inversedBy: 'activities')]
    private Collection $nurses;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adminbyplace $adminbyplace = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'activities')]
    private Collection $participations;



    public function __construct()
    {
        $this->donors = new ArrayCollection();
        $this->nurses = new ArrayCollection();
        $this->participations = new ArrayCollection();
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

    /**
     * @return Collection<int, Nurse>
     */
    public function getNurses(): Collection
    {
        return $this->nurses;
    }

    public function addNurse(Nurse $nurse): static
    {
        if (!$this->nurses->contains($nurse)) {
            $this->nurses->add($nurse);
        }

        return $this;
    }

    public function removeNurse(Nurse $nurse): static
    {
        $this->nurses->removeElement($nurse);

        return $this;
    }

    public function getAdminbyplace(): ?Adminbyplace
    {
        return $this->adminbyplace;
    }

    public function setAdminbyplace(Adminbyplace $adminbyplace): static
    {
        $this->adminbyplace = $adminbyplace;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setActivities($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getActivities() === $this) {
                $participation->setActivities(null);
            }
        }

        return $this;
    }
}
