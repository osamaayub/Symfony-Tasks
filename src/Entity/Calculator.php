<?php

namespace App\Entity;

use App\Repository\CalculatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculatorRepository::class)]
class Calculator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number1 = null;

    #[ORM\Column]
    private ?int $number2 = null;

    #[ORM\Column(length: 255)]
    private ?string $operator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber1(): ?int
    {
        return $this->number1;
    }

    public function setNumber1(int $number1): static
    {
        $this->number1 = $number1;

        return $this;
    }

    public function getNumber2(): ?int
    {
        return $this->number2;
    }

    public function setNumber2(int $number2): static
    {
        $this->number2 = $number2;

        return $this;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(string $operator): static
    {
        $this->operator = $operator;

        return $this;
    }
}
