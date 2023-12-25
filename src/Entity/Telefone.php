<?php

namespace App\Entity;

use App\Repository\TelefoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelefoneRepository::class)]
class Telefone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    private ?string $numero = null;

    #[ORM\ManyToOne(inversedBy: 'telefones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aluno $aluno = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getAluno(): ?Aluno
    {
        return $this->aluno;
    }

    public function setAluno(?Aluno $aluno): static
    {
        $this->aluno = $aluno;

        return $this;
    }
}
