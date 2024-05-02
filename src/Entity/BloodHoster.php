<?php

namespace App\Entity;

use App\Repository\BloodHosterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BloodHosterRepository::class)]
class BloodHoster
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $type_bh = null;

    #[ORM\Column(length: 60)]
    private ?string $name_bh = null;

    #[ORM\Column(length: 60)]
    private ?string $location = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 60)]
    private ?string $email = null;

    /**
     * @var Collection<int, Donor>
     */
    #[ORM\ManyToMany(targetEntity: Donor::class, mappedBy: 'id')]
    private Collection $donors;

    public function __construct()
    {
        $this->donors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeBh(): ?string
    {
        return $this->type_bh;
    }

    public function setTypeBh(string $type_bh): static
    {
        $this->type_bh = $type_bh;

        return $this;
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

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $string): static
    {
        $this->email = $string;

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
            $donor->addId($this);
        }

        return $this;
    }

    public function removeDonor(Donor $donor): static
    {
        if ($this->donors->removeElement($donor)) {
            $donor->removeId($this);
        }

        return $this;
    }
}
