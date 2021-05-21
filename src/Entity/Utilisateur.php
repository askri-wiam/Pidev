<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @Groups ("post:read")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUtilisateur;

    /**
     * @var string
     * @Groups ("post:read")
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    private $fullName;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="idCoach")
     */
    private $rdvList;


    /**
     * @var string
     * @Groups ("post:read")
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     * @Groups ("post:read")
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=20, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=20, nullable=false)
     */
    private $motdepasse;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=10000, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=false)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="Date_naiss", type="string", length=10, nullable=false)
     */
    private $dateNaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="isvalider", type="boolean", nullable=false)
     */
    private $isvalider;

    /**
     * @var string
     *
     * @ORM\Column(name="activite", type="string", length=100, nullable=false)
     */
    private $activite;

    public function __construct(){

        $this->rdvList = new ArrayCollection();
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaiss(): ?string
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(string $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIsvalider(): ?bool
    {
        return $this->isvalider;
    }

    public function setIsvalider(bool $isvalider): self
    {
        $this->isvalider = $isvalider;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->nom.' '.$this->prenom;
    }


    /**
     * @return Collection|Rdv[]
     */
    public function getRdvList(): Collection
    {
        return $this->rdvList;
    }

    public function addRdvList(Rdv $rdv): self
    {
        if (!$this->rdvList->contains($rdv)) {
            $this->rdvList[] = $rdv;
            $rdv->setIdCoach($this);
        }

        return $this;
    }

    public function removeRdvList(Rdv $rdv): self
    {
        if ($this->rdvList->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getIdCoach() === $this) {
                $rdv->setIdCoach(null);
            }
        }

        return $this;
    }


}
