<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OffreRepository")
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nbVue", type="integer")
     *
     */
    private $nbvue;

    /**
     * @var int
     *
     * @ORM\Column(name="signale", type="integer")
     *
     */
    private $signale;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", nullable=false)
     */
    private $utilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=255)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="profil", type="string", length=255)
     */
    private $profil;

    /**
     * @var string
     *
     * @ORM\Column(name="societe", type="string", length=255)
     */
    private $societe;

    /**
     * @var string
     *
     * @ORM\Column(name="mission", type="text")
     */
    private $mission;

    /**
     * @var string
     *
     * @ORM\Column(name="lieux", type="string", length=255)
     */
    private $lieux;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb", type="datetime")
     */
    private $dateDeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateExpiration", type="datetime")
     */
    private $dateExpiration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime")
     */
    private $datePublication;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get nbvue
     *
     * @return int
     */
    public function getNbvue()
    {
        return $this->nbvue;
    }

    /**
     * Set nbvue
     * @param int $nbvue
     *
     * @return Offre
     */
    public function setNbvue($nbvue)
    {
       $this->nbvue=$nbvue;
       return $this;
    }

    /**
     * Get signale
     *
     * @return int
     */
    public function getSignale()
    {
        return $this->signale;
    }

    /**
     * Set signale
     * @param int $signale
     *
     * @return Offre
     */
    public function setSignale($signale)
    {
        $this->signale=$signale;
        return $this;
    }



    /**
     * Set poste
     *
     * @param string $poste
     *
     * @return Offre
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set poste
     *
     * @param string $poste
     *
     * @return Offre
     */
    public function setLieux($poste)
    {
        $this->lieux = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getLieux()
    {
        return $this->lieux;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Offre
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set societe
     *
     * @param string $societe
     *
     * @return Offre
     */
    public function setSociete($societe)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return string
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set mission
     *
     * @param string $mission
     *
     * @return Offre
     */
    public function setProfil($mission)
    {
        $this->profil = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return string
     */
    public function getProfil()
    {
        return $this->profil;
    }


    /**
     * Set mission
     *
     * @param string $mission
     *
     * @return Offre
     */
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return string
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set dateDeb
     *
     * @param \DateTime $dateDeb
     *
     * @return Offre
     */
    public function setDateDeb($dateDeb)
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime
     */
    public function getDateDeb()
    {
        return $this->dateDeb;
    }

    /**
     * Set dateExpiration
     *
     * @param \DateTime $dateExpiration
     *
     * @return Offre
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * Get dateExpiration
     *
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Offre
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set Utilisateur
     *
     * @param User $utilisateur
     *
     * @return Offre
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get Utilisateur
     *
     * @return User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}

