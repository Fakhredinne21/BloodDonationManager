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
     * @var Collection<int, Bloodbank>
     */
    #[ORM\ManyToMany(targetEntity: Bloodbank::class, mappedBy: 'bloodhoster')]
    private Collection $bloodbank;

    /**
     * @var Collection<int, bloodcategory>
     */
    #[ORM\ManyToMany(targetEntity: bloodcategory::class, inversedBy: 'bloodHosters')]
    private Collection $blood_categ;

    public function __construct()
    {
        $this->bloodbank = new ArrayCollection();
        $this->blood_categ = new ArrayCollection();
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
     * @return Collection<int, Bloodbank>
     */
    public function getBloodbank(): Collection
    {
        return $this->bloodbank;
    }

    public function addBloodbank(Bloodbank $bloodbank): static
    {
        if (!$this->bloodbank->contains($bloodbank)) {
            $this->bloodbank->add($bloodbank);
            $bloodbank->addBloodhoster($this);
        }

        return $this;
    }

    public function removeBloodbank(Bloodbank $bloodbank): static
    {
        if ($this->bloodbank->removeElement($bloodbank)) {
            $bloodbank->removeBloodhoster($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, bloodcategory>
     */
    public function getBloodCateg(): Collection
    {
        return $this->blood_categ;
    }

    public function addBloodCateg(bloodcategory $bloodCateg): static
    {
        if (!$this->blood_categ->contains($bloodCateg)) {
            $this->blood_categ->add($bloodCateg);
        }

        return $this;
    }

    public function removeBloodCateg(bloodcategory $bloodCateg): static
    {
        $this->blood_categ->removeElement($bloodCateg);

        return $this;
    }
}
