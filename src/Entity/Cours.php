<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="idf", columns={"idf"})})
 * @ORM\Entity
 */
class Cours
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="blob", length=0, nullable=false)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="blob", length=0, nullable=false)
     */
    private $image;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idf", referencedColumnName="id")
     * })
     */
    private $idf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdf(): ?Formation
    {
        return $this->idf;
    }

    public function setIdf(?Formation $idf): self
    {
        $this->idf = $idf;

        return $this;
    }


}
