<?php

namespace App\Entity;



use App\Repository\DonorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ORM\Entity(repositoryClass: DonorRepository::class)]
class Donor extends Users
{

    #[ORM\Column]
    private ?int $state = 0;

    /**
     * @var Collection<int, BloodHoster>
     */
    #[ORM\ManyToMany(targetEntity: BloodHoster::class, inversedBy: 'donors')]
    private Collection $id_hoster;

    #[ORM\Column(length: 255)]
    private ?string $BloodType = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $agree = null ;
    #[ORM\Column(type: "string", length: 255)]
    private ?string $Email = null;



    #[ORM\ManyToOne(inversedBy: 'donor')]
    private ?Participation $participation = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\ManyToMany(targetEntity: Participation::class, mappedBy: 'approvedDonors')]
    private Collection $ApprovedPartcipations;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'Donor')]
    private Collection $participationsDonor;

    public function __construct()
    {
        $this->id = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->ApprovedPartcipations = new ArrayCollection();
        $this->participationsDonor = new ArrayCollection();
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

    public function getId(): int
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

    public function getBloodType(): ?string
    {
        return $this->BloodType;
    }

    public function setBloodType(string $BloodType): static
    {
        $this->BloodType = $BloodType;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAgree(): ?bool
    {
        return $this->agree;
    }

    public function setAgree(bool $agree): self
    {
        $this->agree = $agree;

        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Activity $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->addDonor($this);
        }

        return $this;
    }

    public function removeParticipation(Activity $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            $participation->removeDonor($this);
        }

        return $this;
    }

    public function getParticipation(): ?Participation
    {
        return $this->participation;
    }

    public function setParticipation(?Participation $participation): static
    {
        $this->participation = $participation;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getApprovedPartcipations(): Collection
    {
        return $this->ApprovedPartcipations;
    }

    public function addApprovedPartcipation(Participation $approvedPartcipation): static
    {
        if (!$this->ApprovedPartcipations->contains($approvedPartcipation)) {
            $this->ApprovedPartcipations->add($approvedPartcipation);
            $approvedPartcipation->addApprovedDonor($this);
        }

        return $this;
    }

    public function removeApprovedPartcipation(Participation $approvedPartcipation): static
    {
        if ($this->ApprovedPartcipations->removeElement($approvedPartcipation)) {
            $approvedPartcipation->removeApprovedDonor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipationsDonor(): Collection
    {
        return $this->participationsDonor;
    }

    public function addParticipationsDonor(Participation $participationsDonor): static
    {
        if (!$this->participationsDonor->contains($participationsDonor)) {
            $this->participationsDonor->add($participationsDonor);
            $participationsDonor->setDonor($this);
        }

        return $this;
    }

    public function removeParticipationsDonor(Participation $participationsDonor): static
    {
        if ($this->participationsDonor->removeElement($participationsDonor)) {
            // set the owning side to null (unless already changed)
            if ($participationsDonor->getDonor() === $this) {
                $participationsDonor->setDonor(null);
            }
        }

        return $this;
    }
}
