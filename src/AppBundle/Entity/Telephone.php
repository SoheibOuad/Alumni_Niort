<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Telephone
 *
 * @ORM\Table(name="telephone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TelephoneRepository")
 */
class Telephone
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
     * @var string
     *
     * @ORM\Column(name="telephone", type="string")
     */
    private $telephone;

    /**
     * @var int
     *
     * @ORM\Column(name="nbVue", type="integer",nullable=true,options={"default"=0})
     */
    private $nbVue;




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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }


    /**
     * Set Utilisateur
     *
     * @param User $utilisateur
     *
     * @return Telephone
     */
    public function setUtilisateur( $utilisateur)
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

