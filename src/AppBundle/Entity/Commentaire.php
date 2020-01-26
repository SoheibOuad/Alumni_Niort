<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var  Annonce
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Annonce")
     * @ORM\JoinColumn(name="id_annoce", nullable=false)
     */
    private $annonce;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commentaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set Utilisateur
     *
     * @param User $utilisateur
     *
     * @return Commentaire
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
    /**
     * Set Annonce
     *
     * @param Annonce $annonce
     *
     * @return Commentaire
     */
    public function setAnnonce( $annonce)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get Annonce
     *
     * @return Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
}

