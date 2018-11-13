<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammingLanguageRepository")
 */
class ProgrammingLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $testString;

    /**
     * @ORM\Column(type="boolean")
     */
    private $testBoolean;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestString(): ?string
    {
        return $this->testString;
    }

    public function setTestString(string $testString): self
    {
        $this->testString = $testString;

        return $this;
    }

    public function getTestBoolean(): ?bool
    {
        return $this->testBoolean;
    }

    public function setTestBoolean(bool $testBoolean): self
    {
        $this->testBoolean = $testBoolean;

        return $this;
    }
}
