<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Routineclient
 *
 * @ORM\Table(name="routineclient")
 * @ORM\Entity(repositoryClass="App\Repository\RoutineclientRepository")
 */
class Routineclient
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTache", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtache;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCoach", type="string", length=30, nullable=false)
     */
    private $nomcoach;

    /**
     * @var string
     *
     * @ORM\Column(name="nomClient", type="string", length=30, nullable=false)
     */
    private $nomclient;

    /**
     * @var string
     *
     * @ORM\Column(name="nomTache", type="string", length=30, nullable=false)
     */
    private $nomtache;

    /**
     * @var string
     *
     * @ORM\Column(name="avancement", type="string", length=50, nullable=false)
     */
    private $avancement;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=5, nullable=false)
     */
    private $duree;

    public function getIdtache(): ?int
    {
        return $this->idtache;
    }

    public function getNomcoach(): ?string
    {
        return $this->nomcoach;
    }

    public function setNomcoach(string $nomcoach): self
    {
        $this->nomcoach = $nomcoach;

        return $this;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getNomtache(): ?string
    {
        return $this->nomtache;
    }

    public function setNomtache(string $nomtache): self
    {
        $this->nomtache = $nomtache;

        return $this;
    }

    public function getAvancement(): ?string
    {
        return $this->avancement;
    }

    public function setAvancement(string $avancement): self
    {
        $this->avancement = $avancement;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }


}
