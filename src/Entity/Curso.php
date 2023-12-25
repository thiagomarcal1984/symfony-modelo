<?php

namespace App\Entity;

use App\Repository\CursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoRepository::class)]
class Curso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\ManyToMany(targetEntity: Aluno::class, inversedBy: 'cursos')]
    private Collection $alunos;

    public function __construct()
    {
        $this->alunos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return Collection<int, Aluno>
     */
    public function getAlunos(): Collection
    {
        return $this->alunos;
    }

    public function addAluno(Aluno $aluno): static
    {
        if (!$this->alunos->contains($aluno)) {
            $this->alunos->add($aluno);
        }

        return $this;
    }

    public function removeAluno(Aluno $aluno): static
    {
        $this->alunos->removeElement($aluno);

        return $this;
    }
}
