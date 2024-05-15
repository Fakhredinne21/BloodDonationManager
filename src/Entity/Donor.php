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
     * @return int|null
     */
    public function getId(): ?int
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
}
