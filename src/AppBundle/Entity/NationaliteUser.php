<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NationaliteUser
 *
 * @ORM\Table(name="nationaliteUser")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NationaliteUserRepository")
 */
class NationaliteUser
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
     * @var  Nationalite
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nationalite")
     * @ORM\JoinColumn(name="id_nationalite", nullable=false)
     */
    private $nationalite;



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
     * @return NationaliteUser
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
     * Set Nationalite
     *
     * @param Nationalite $nationalite
     *
     * @return NationaliteUser
     */
    public function setNationalite( $nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get Nationalite
     *
     * @return Nationalite
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }


}

