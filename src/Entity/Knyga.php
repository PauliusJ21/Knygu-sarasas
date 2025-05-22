<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\KnygaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KnygaRepository::class)]
class Knyga
{
    #ID
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #Pavadinimas 
    #[Assert\NotBlank(message: 'Pavadinimas negali būti tuščias!')]
    #[ORM\Column(length: 255)]
    private ?string $pavadinimas = null;

    #[ORM\Column(length: 255)]
    private ?string $autorius = null;

    #Išleidimo Metai
    //Datos tikrinimas
    #[Assert\NotBlank(message: 'Išleidimo metai negali būti tušti!')]
    #[Assert\Range(
        min: 1,
        max: 2025,
        notInRangeMessage: 'Metai turi būti tarp {{ min }} ir {{ max }}.'
    )]
    #[ORM\Column]
    private ?int $isleidimoMetai = null;

    #ISBN numeris
    //ISBN numerio tikrinimas
    #[Assert\NotBlank(message: 'ISBN numeris negali būti tuščias!')]
     #[Assert\Isbn(
        type: Assert\Isbn::ISBN_10 | Assert\Isbn::ISBN_13,
        message: 'Prašome pateikti tinkamą ISBN numerio formatą: ISBN 10 arba ISBN 13.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $isbnNumeris = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPavadinimas(): ?string
    {
        return $this->pavadinimas;
    }

    public function setPavadinimas(string $pavadinimas): static
    {
        $this->pavadinimas = $pavadinimas;

        return $this;
    }

    public function getAutorius(): ?string
    {
        return $this->autorius;
    }

    public function setAutorius(string $autorius): static
    {
        $this->autorius = $autorius;

        return $this;
    }

    public function getIsleidimoMetai(): ?int
    {
        return $this->isleidimoMetai;
    }

    public function setIsleidimoMetai(int $isleidimoMetai): static
    {
        $this->isleidimoMetai = $isleidimoMetai;

        return $this;
    }

    public function getIsbnNumeris(): ?string
    {
        return $this->isbnNumeris;
    }

    public function setIsbnNumeris(string $isbnNumeris): static
    {
        $this->isbnNumeris = $isbnNumeris;

        return $this;
    }
}
