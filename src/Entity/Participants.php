<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participants
 *
 * @ORM\Table(name="participants", indexes={@ORM\Index(name="idclient", columns={"idclient", "idformation"}), @ORM\Index(name="FK_716970923E5B884A", columns={"idformation"}), @ORM\Index(name="IDX_71697092A3F9A9F9", columns={"idclient"})})
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantsRepository")
 */
class Participants
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idformation", referencedColumnName="id")
     * })
     */
    private $idformation;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idclient", referencedColumnName="id_utilisateur")
     * })
     */
    private $idclient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdformation(): ?Formation
    {
        return $this->idformation;
    }

    public function setIdformation(?Formation $idformation): self
    {
        $this->idformation = $idformation;

        return $this;
    }

    public function getIdclient(): ?Utilisateur
    {
        return $this->idclient;
    }

    public function setIdclient(?Utilisateur $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }


}
