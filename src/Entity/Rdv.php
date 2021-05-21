<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Rdv
 *
 * @ORM\Table(name="rdv")
 * @ORM\Entity(repositoryClass="App\Repository\RdvRepository")
 */
class Rdv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups ("post:read")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="Ncoach", type="string")
     * @Groups ("post:read")
     */
    private $Ncoach;

    /**
     * @return string
     */
    public function getNcoach(): ?string
    {
        return $this->Ncoach;
    }

    /**
     * @param string $Ncoach
     */
    public function setNcoach(string $Ncoach): void
    {
        $this->Ncoach = $Ncoach;
    }



    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="rdvList")
     * @ORM\JoinColumn(name="id_coach",referencedColumnName="id_utilisateur",nullable=false)
     */
    private $idCoach;

    /**
     * @var string
     * @Groups ("post:read")
     * @ORM\Column(name="date", type="string", length=20, nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=30, nullable=false)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdCoach(): ?Utilisateur
    {
        return $this->idCoach;
    }

    public function setIdCoach(Utilisateur $idCoach): self
    {
        $this->idCoach = $idCoach;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


}
