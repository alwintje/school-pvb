<?php
/**
 * Created by PhpStorm.
 * User: Alwin Kroesen
 * Date: 13-2-2015
 * Time: 11:12
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="SoortCursus")
 * @ORM\Entity()
 */
class SoortCursus
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $naam;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $prijs;

    /**
     * @ORM\OneToMany(targetEntity="Cursus", mappedBy="SoortCursus")
     *
     */
    private $cursus;


    public function __construct()
    {
//        $this->users = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set naam
     *
     * @param string $naam
     *
     * @return SoortCursus
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * Get naam
     *
     * @return string
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * Set prijs
     *
     * @param integer $prijs
     *
     * @return SoortCursus
     */
    public function setPrijs($prijs)
    {
        $this->prijs = $prijs;

        return $this;
    }

    /**
     * Get prijs
     *
     * @return integer
     */
    public function getPrijs()
    {
        return $this->prijs;
    }

    /**
     * Set cursus
     *
     * @param \AppBundle\Entity\Cursus $cursus
     *
     * @return SoortCursus
     */
    public function setCursus(\AppBundle\Entity\Cursus $cursus = null)
    {
        $this->cursus = $cursus;

        return $this;
    }

    /**
     * Get cursus
     *
     * @return \AppBundle\Entity\Cursus
     */
    public function getCursus()
    {
        return $this->cursus;
    }

    /**
     * Add cursus
     *
     * @param \AppBundle\Entity\Cursus $cursus
     *
     * @return SoortCursus
     */
    public function addCursus(\AppBundle\Entity\Cursus $cursus)
    {
        $this->cursus[] = $cursus;

        return $this;
    }

    /**
     * Remove cursus
     *
     * @param \AppBundle\Entity\Cursus $cursus
     */
    public function removeCursus(\AppBundle\Entity\Cursus $cursus)
    {
        $this->cursus->removeElement($cursus);
    }
}
