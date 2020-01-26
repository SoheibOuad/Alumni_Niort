<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nbvue
 *
 * @ORM\Table(name="nbvue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NbvueRepository")
 */
class Nbvue
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
     * @ORM\Column(name="nbvue", type="integer",options={"default"=0})
     */
    private $nbvue;


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
     * Set nbvue
     *
     * @param integer $nbvue
     *
     * @return Nbvue
     */
    public function setNbvue($nbvue)
    {
        $this->nbvue = $nbvue;

        return $this;
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
}

