<?php
/**
 * Created by PhpStorm.
 * User: Alwin Kroesen
 * Date: 12-2-2015
 * Time: 14:06
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="cursus")
 * @ORM\Entity()
 */
class Cursus
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     */
    private $beginDatum;

    /**
     * @ORM\Column(type="date")
     */
    private $eindDatum;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $image;


    /**
     * @ORM\ManyToOne(targetEntity="SoortCursus", inversedBy="cursus")
     */
    private $soortCursus;



    /**
     * @ORM\ManyToMany(targetEntity="\UserBundle\Entity\User", mappedBy="workshops")
     */
    private $cursisten;



    public function __construct()
    {
        $this->soortCursus = new ArrayCollection();
        $this->cursisten = new ArrayCollection();
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
     * Set beginDatum
     *
     * @param \DateTime $beginDatum
     *
     * @return Cursus
     */
    public function setBeginDatum($beginDatum)
    {
        $this->beginDatum = $beginDatum;

        return $this;
    }

    /**
     * Get beginDatum
     *
     * @return \DateTime
     */
    public function getBeginDatum()
    {
        return $this->beginDatum;
    }

    /**
     * Set eindDatum
     *
     * @param \DateTime $eindDatum
     *
     * @return Cursus
     */
    public function setEindDatum($eindDatum)
    {
        $this->eindDatum = $eindDatum;

        return $this;
    }

    /**
     * Get eindDatum
     *
     * @return \DateTime
     */
    public function getEindDatum()
    {
        return $this->eindDatum;
    }


    /**
     * Add soortCursus
     *
     * @param \AppBundle\Entity\SoortCursus $soortCursus
     *
     * @return Cursus
     */
    public function addSoortCursus(\AppBundle\Entity\SoortCursus $soortCursus)
    {
        $this->soortCursus[] = $soortCursus;

        return $this;
    }

    /**
     * Remove soortCursus
     *
     * @param \AppBundle\Entity\SoortCursus $soortCursus
     */
    public function removeSoortCursus(\AppBundle\Entity\SoortCursus $soortCursus)
    {
        $this->soortCursus->removeElement($soortCursus);
    }

    /**
     * Get soortCursus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoortCursus()
    {
        return $this->soortCursus;
    }

    /**
     * Add cursisten
     *
     * @param \UserBundle\Entity\User $cursisten
     *
     * @return Cursus
     */
    public function addCursisten(\UserBundle\Entity\User $cursisten)
    {
        $this->cursisten[] = $cursisten;

        return $this;
    }

    /**
     * Remove cursisten
     *
     * @param \UserBundle\Entity\User $cursisten
     */
    public function removeCursisten(\UserBundle\Entity\User $cursisten)
    {
        $this->cursisten->removeElement($cursisten);
    }

    /**
     * Get cursisten
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCursisten()
    {
        return $this->cursisten;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Cursus
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set soortCursus
     *
     * @param \AppBundle\Entity\SoortCursus $soortCursus
     *
     * @return Cursus
     */
    public function setSoortCursus(\AppBundle\Entity\SoortCursus $soortCursus = null)
    {
        $this->soortCursus = $soortCursus;

        return $this;
    }
}
