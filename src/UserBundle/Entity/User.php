<?php
/**
 * Created by PhpStorm.
 * User: Alwin Kroesen
 * Date: 12-2-2015
 * Time: 14:06
 */

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $voornaam;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $tussenVoegsels;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $achternaam;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adres;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $woonplaats;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $telefoon;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Cursus", inversedBy="users")
     */
    private $workshops;


    public function __construct()
    {
        $this->isActive = true;
        $this->roles = new ArrayCollection();
        $this->workshops = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        //return array('ROLE_USER');
        return $this->roles->toArray();
    }

    /**
     * @inheritDoc
     */
    public function hasRole($role)
    {
        //return array('ROLE_USER');
        foreach($this->roles->toArray() as $val){
            if($val == $role){
                return true;
            }
        }
        return false;
        //return $this->roles->toArray();
    }
    /**
     * @inheritDoc
     */
    public function hasWorkshop($workshop)
    {
        //return array('ROLE_USER');
        foreach($this->workshops->toArray() as $val){
            if($val == $workshop){
                return true;
            }
        }
        return false;
        //return $this->roles->toArray();
    }
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Add roles
     *
     * @param \UserBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \UserBundle\Entity\Role $roles
     */
    public function removeRole(\UserBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set voornaam
     *
     * @param string $voornaam
     *
     * @return User
     */
    public function setVoornaam($voornaam)
    {
        $this->voornaam = $voornaam;

        return $this;
    }

    /**
     * Get voornaam
     *
     * @return string
     */
    public function getVoornaam()
    {
        return $this->voornaam;
    }

    /**
     * Set tussenVoegsels
     *
     * @param string $tussenVoegsels
     *
     * @return User
     */
    public function setTussenVoegsels($tussenVoegsels)
    {
        $this->tussenVoegsels = $tussenVoegsels;

        return $this;
    }

    /**
     * Get tussenVoegsels
     *
     * @return string
     */
    public function getTussenVoegsels()
    {
        return $this->tussenVoegsels;
    }

    /**
     * Set achternaam
     *
     * @param string $achternaam
     *
     * @return User
     */
    public function setAchternaam($achternaam)
    {
        $this->achternaam = $achternaam;

        return $this;
    }

    /**
     * Get achternaam
     *
     * @return string
     */
    public function getAchternaam()
    {
        return $this->achternaam;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Set adres
     *
     * @param string $adres
     *
     * @return User
     */
    public function setAdres($adres)
    {
        $this->adres = $adres;

        return $this;
    }

    /**
     * Get adres
     *
     * @return string
     */
    public function getAdres()
    {
        return $this->adres;
    }

    /**
     * Set woonplaats
     *
     * @param string $woonplaats
     *
     * @return User
     */
    public function setWoonplaats($woonplaats)
    {
        $this->woonplaats = $woonplaats;

        return $this;
    }

    /**
     * Get woonplaats
     *
     * @return string
     */
    public function getWoonplaats()
    {
        return $this->woonplaats;
    }

    /**
     * Set telefoon
     *
     * @param string $telefoon
     *
     * @return User
     */
    public function setTelefoon($telefoon)
    {
        $this->telefoon = $telefoon;

        return $this;
    }

    /**
     * Get telefoon
     *
     * @return string
     */
    public function getTelefoon()
    {
        return $this->telefoon;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add workshop
     *
     * @param \AppBundle\Entity\Cursus $workshop
     *
     * @return User
     */
    public function addWorkshop(\AppBundle\Entity\Cursus $workshop)
    {
        $this->workshops[] = $workshop;

        return $this;
    }

    /**
     * Remove workshop
     *
     * @param \AppBundle\Entity\Cursus $workshop
     */
    public function removeWorkshop(\AppBundle\Entity\Cursus $workshop)
    {
        $this->workshops->removeElement($workshop);
    }

    /**
     * Get workshops
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkshops()
    {
        return $this->workshops;
    }
}
