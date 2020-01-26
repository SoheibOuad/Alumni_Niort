<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postule
 *
 * @ORM\Table(name="postule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostuleRepository")
 */
class Postule
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", nullable=false)
     */
    private $utilisateur;

    /**
     * @var  Offre
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Offre")
     * @ORM\JoinColumn(name="id_offre", nullable=false)
     */
    private $offre;



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
     * Set Utilisateur
     *
     * @param User $utilisateur
     *
     * @return Postule
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

    /**
     * Set Offre
     *
     * @param Offre $offre
     *
     * @return Postule
     */
    public function setOffre($offre)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get Nationalite
     *
     * @return Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }

}

