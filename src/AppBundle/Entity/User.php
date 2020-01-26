<?php


namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser ;
use Doctrine\ORM\Mapping as ORM;



/**
 * Class User
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="user_admine")
 *
 */

class User extends BaseUser
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string",nullable=true,options={"default"=NULL})
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=true,options={"default"=NULL})
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=true,options={"default"=NULL})
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="boolean",nullable=true,options={"default"=0})
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="diplome", type="string", length=30, nullable=true,options={"default"=NULL})
     */
    private $diplome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entree",type="datetime",nullable=true,options={"default"=NULL})
     */
    private $dateEntree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sortie", type="datetime",nullable=true,options={"default"=NULL})
     */
    private $dateSortie;

    /**
     * @var int
     *
     * @ORM\Column(name="etudiant",type="integer",nullable=true,options={"default"=NULL})
     *
     */

    private $etudiant ;

    /**
     * @var int
     *
     * @ORM\Column(name="cliqueOffre",type="integer",nullable=true,options={"default"=NULL})
     *
     */

    private $cliqueOffre ;
    /**
     * @var int
     *
     * @ORM\Column(name="cliqueActualite",type="integer",nullable=true,options={"default"=NULL})
     *
     */

    private $cliqueActualite ;
    /**
     * @var int
     *
     * @ORM\Column(name="cliqueSandage",type="integer",nullable=true,options={"default"=NULL})
     *
     */

    private $cliqueSandage ;
    /**
     * @var int
     *
     * @ORM\Column(name="acceptmail",type="integer",nullable=true,options={"default"=NULL})
     *
     */

    private $acceptmail ;
    /**
     * @var int
     *
     * @ORM\Column(name="accepttelephone",type="integer",nullable=true,options={"default"=NULL})
     *
     */

    private $accepttelephone ;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateOffre",type="datetime",nullable=true,options={"default"=NULL})
     */
    private $DateOffre;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateSandage",type="datetime",nullable=true,options={"default"=NULL})
     */
    private $DateSandage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateActualite",type="datetime",nullable=true,options={"default"=NULL})
     */
    private $DateActualite;

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */


    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
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
     * Set etudiant
     *
     * @param int $etudiant
     *
     * @return User
     */


    public function setEtudiant($etudiant)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return int
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set cliqueOffre
     *
     * @param int $cliqueOffre
     *
     * @return User
     */


    public function setcliqueOffre($cliqueOffre)
    {
        $this->cliqueOffre = $cliqueOffre;

        return $this;
    }

    /**
     * Get cliqueOffre
     *
     * @return int
     */
    public function getcliqueOffre()
    {
        return $this->cliqueOffre;
    }

    /**
     * Set cliqueActualite
     *
     * @param int $cliqueActualite
     *
     * @return User
     */


    public function setcliqueActualite($cliqueActualite)
    {
        $this->cliqueActualite = $cliqueActualite;

        return $this;
    }

    /**
     * Get cliqueActualite
     *
     * @return int
     */
    public function getcliqueActualite()
    {
        return $this->cliqueActualite;
    }

    /**
     * Set cliqueSandage
     *
     * @param int $cliqueSandage
     *
     * @return User
     */


    public function setcliqueSandage($cliqueSandage)
    {
        $this->cliqueSandage = $cliqueSandage;

        return $this;
    }

    /**
     * Get cliqueSandage
     *
     * @return int
     */
    public function getcliqueSandage()
    {
        return $this->cliqueSandage;
    }


    /**
     * Set acceptmail
     *
     * @param int $acceptmail
     *
     * @return User
     */


    public function setacceptmail($acceptmail)
    {
        $this->acceptmail = $acceptmail;

        return $this;
    }

    /**
     * Get acceptmail
     *
     * @return int
     */
    public function getacceptmail()
    {
        return $this->acceptmail;
    }

    /**
     * Set accepttelephone
     *
     * @param int $accepttelephone
     *
     * @return User
     */


    public function setaccepttelephone($accepttelephone)
    {
        $this->accepttelephone = $accepttelephone;

        return $this;
    }

    /**
     * Get accepttelephone
     *
     * @return int
     */
    public function getaccepttelephone()
    {
        return $this->accepttelephone;
    }







    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return User
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set diplome
     *
     * @param string $diplome
     *
     * @return User
     */


    public function setDiplome($diplome)
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * Get diplome
     *
     * @return string
     */
    public function getDiplome()
    {
        return $this->diplome;
    }



    /**
     * Set dateDeb
     *
     * @param \DateTime $dateEntree
     *
     * @return User
     */
    public function setDateEntree($dateEntree)
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime
     */
    public function getDateEntree()
    {
        return $this->dateEntree;
    }


    /**
     * Set dateDeb
     *
     * @param \DateTime $dateSortie
     *
     * @return User
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set DateOffre
     *
     * @param \DateTime $DateOffre
     *
     * @return User
     */
    public function setDateOffre($DateOffre)
    {
        $this->DateOffre = $DateOffre;

        return $this;
    }

    /**
     * Get DateOffre
     *
     * @return \DateTime
     */
    public function getDateOffre()
    {
        return $this->DateOffre;
    }


    /**
     * Set DateActualite
     *
     * @param \DateTime $DateActualite
     *
     * @return User
     */
    public function setDateActualite($DateActualite)
    {
        $this->DateActualite = $DateActualite;

        return $this;
    }

    /**
     * Get DateActualite
     *
     * @return \DateTime
     */
    public function getDateActualite()
    {
        return $this->DateActualite;
    }


    /**
     * Set DateSandage
     *
     * @param \DateTime $DateSandage
     *
     * @return User
     */
    public function setDateSandage($DateSandage)
    {
        $this->DateSandage = $DateSandage;

        return $this;
    }

    /**
     * Get DateSandage
     *
     * @return \DateTime
     */
    public function getDateSandage()
    {
        return $this->DateSandage;
    }


    public function __construct()
    {
        parent::__construct();
    }


}