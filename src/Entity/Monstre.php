<?php

namespace App\Entity;

use App\Repository\MonstreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MonstreRepository::class)]
class Monstre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,unique: true)]
    #[Assert\Regex(pattern:"/^[A-Z][a-z]*$/",message:"Le nom doit contenir une majuscule en premier caractère et que des miniscules ensuite.")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(['Zombie', 'Vampire', 'Orque', 'Titan', 'Ogre', 'Lutin'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'La puissance du monstre doit être comprise entre {{ min }} et {{ max }}',
    )]
    private ?int $puissance = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\GreaterThan(value:0,message:"La taille du monstre doit être supérieure à {{ compared_value }}")]
    private ?int $taille = null;

    #[ORM\ManyToOne(inversedBy: 'monstres')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Royaume $royaume = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): static
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getRoyaume(): ?Royaume
    {
        return $this->royaume;
    }

    public function setRoyaume(?Royaume $royaume): static
    {
        $this->royaume = $royaume;

        return $this;
    }
}
