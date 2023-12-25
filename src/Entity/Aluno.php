<?php

namespace App\Entity;

use App\Repository\AlunoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlunoRepository::class)]
class Aluno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\OneToMany(mappedBy: 'aluno', targetEntity: Telefone::class)]
    private Collection $telefones;

    #[ORM\ManyToMany(targetEntity: Curso::class, mappedBy: 'alunos')]
    private Collection $cursos;

    public function __construct()
    {
        $this->telefones = new ArrayCollection();
        $this->cursos = new ArrayCollection();
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
     * @return Collection<int, Telefone>
     */
    public function getTelefones(): Collection
    {
        return $this->telefones;
    }

    public function addTelefone(Telefone $telefone): static
    {
        if (!$this->telefones->contains($telefone)) {
            $this->telefones->add($telefone);
            $telefone->setAluno($this);
        }

        return $this;
    }

    public function removeTelefone(Telefone $telefone): static
    {
        if ($this->telefones->removeElement($telefone)) {
            // set the owning side to null (unless already changed)
            if ($telefone->getAluno() === $this) {
                $telefone->setAluno(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Curso>
     */
    public function getCursos(): Collection
    {
        return $this->cursos;
    }

    public function addCurso(Curso $curso): static
    {
        if (!$this->cursos->contains($curso)) {
            $this->cursos->add($curso);
            $curso->addAluno($this);
        }

        return $this;
    }

    public function removeCurso(Curso $curso): static
    {
        if ($this->cursos->removeElement($curso)) {
            $curso->removeAluno($this);
        }

        return $this;
    }
}
