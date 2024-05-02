<?php

namespace App\Entity;

use App\Repository\AdminbyplaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminbyplaceRepository::class)]
class Adminbyplace extends User
{

}
