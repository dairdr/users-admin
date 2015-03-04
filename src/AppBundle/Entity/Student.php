<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="estudiante")
 * @ORM\Entity
 */
class Student
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="names", type="string", length=45)
     */
    private $names;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=45)
     */
    private $lastname;

    /**
     * @var boolean
     *
     * @ORM\Column(name="voted", type="boolean")
     */
    private $voted;

    /**
     * @var integer
     *
     * @ORM\Column(name="vote_counting", type="integer")
     */
    private $voteCounting;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_personero", type="boolean")
     */
    private $isPersonero;


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
     * Set names
     *
     * @param string $names
     * @return Student
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
    }

    /**
     * Get names
     *
     * @return string 
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Student
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set voted
     *
     * @param boolean $voted
     * @return Student
     */
    public function setVoted($voted)
    {
        $this->voted = $voted;

        return $this;
    }

    /**
     * Get voted
     *
     * @return boolean 
     */
    public function getVoted()
    {
        return $this->voted;
    }

    /**
     * Set voteCounting
     *
     * @param integer $voteCounting
     * @return Student
     */
    public function setVoteCounting($voteCounting)
    {
        $this->voteCounting = $voteCounting;

        return $this;
    }

    /**
     * Get voteCounting
     *
     * @return integer 
     */
    public function getVoteCounting()
    {
        return $this->voteCounting;
    }

    /**
     * Set isPersonero
     *
     * @param boolean $isPersonero
     * @return Student
     */
    public function setIsPersonero($isPersonero)
    {
        $this->isPersonero = $isPersonero;

        return $this;
    }

    /**
     * Get isPersonero
     *
     * @return boolean 
     */
    public function getIsPersonero()
    {
        return $this->isPersonero;
    }
}
