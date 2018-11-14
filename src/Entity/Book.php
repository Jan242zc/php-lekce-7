<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pocet_stran;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $autor;

    /**
     * @ORM\Column(type="integer")
     */
    private $rok_vydani;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cena;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPocetStran(): ?int
    {
        return $this->pocet_stran;
    }

    public function setPocetStran(int $pocet_stran): self
    {
        $this->pocet_stran = $pocet_stran;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getRokVydani(): ?int
    {
        return $this->rok_vydani;
    }

    public function setRokVydani(int $rok_vydani): self
    {
        $this->rok_vydani = $rok_vydani;

        return $this;
    }

    public function getCena(): ?int
    {
        return $this->cena;
    }

    public function setCena(?int $cena): self
    {
        $this->cena = $cena;

        return $this;
    }
}
