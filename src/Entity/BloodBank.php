<?php

namespace App\Entity;

use App\Repository\BloodBankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BloodBankRepository::class)]
class BloodBank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_bh = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, bloodhoster>
     */
    #[ORM\ManyToMany(targetEntity: bloodhoster::class, inversedBy: 'bloodbank')]
    private Collection $bloodhoster;

    public function __construct()
    {
        $this->bloodhoster = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBh(): ?string
    {
        return $this->name_bh;
    }

    public function setNameBh(string $name_bh): static
    {
        $this->name_bh = $name_bh;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, bloodhoster>
     */
    public function getBloodhoster(): Collection
    {
        return $this->bloodhoster;
    }

    public function addBloodhoster(bloodhoster $bloodhoster): static
    {
        if (!$this->bloodhoster->contains($bloodhoster)) {
            $this->bloodhoster->add($bloodhoster);
        }

        return $this;
    }

    public function removeBloodhoster(bloodhoster $bloodhoster): static
    {
        $this->bloodhoster->removeElement($bloodhoster);

        return $this;
    }
}
