<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table(name="participer", indexes={@ORM\Index(name="id_event", columns={"id_event", "id_Participant"})})
 * @ORM\Entity(repositoryClass="App\Repository\ParticiperRepository")
 */
class Participer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Participant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idParticipant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reponseEvent", type="string", length=50, nullable=true)
     */
    private $reponseevent;

    /**
     * @var string
     *
     * @ORM\Column(name="date_participation", type="string", length=100, nullable=false)
     */
    private $dateParticipation;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_participant", type="integer", nullable=false)
     */
    private $nbParticipant;

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function getIdParticipant(): ?int
    {
        return $this->idParticipant;
    }

    public function getReponseevent(): ?string
    {
        return $this->reponseevent;
    }

    public function setReponseevent(?string $reponseevent): self
    {
        $this->reponseevent = $reponseevent;

        return $this;
    }

    public function getDateParticipation(): ?string
    {
        return $this->dateParticipation;
    }

    public function setDateParticipation(string $dateParticipation): self
    {
        $this->dateParticipation = $dateParticipation;

        return $this;
    }

    public function getNbParticipant(): ?int
    {
        return $this->nbParticipant;
    }

    public function setNbParticipant(int $nbParticipant): self
    {
        $this->nbParticipant = $nbParticipant;

        return $this;
    }


}
