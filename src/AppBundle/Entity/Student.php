<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Student
 *
 * @ORM\Table(name="estudiante")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(name="vote_counting", type="integer", nullable=true)
     */
    private $voteCounting;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_candidate", type="boolean")
     */
    private $isCandidate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45)
     */
    private $code;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="is_personero", type="boolean")
     */
    private $isPersonero;
    
    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;
    
    /**
     * @var string
     *
     */
    private $temp;
    
    /**
     * @var UploadedFile
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    /**
     * @var Grade
     * @ORM\ManyToOne(targetEntity="Grade", inversedBy="student")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id", nullable=false)
     */
    private $grade;
    
    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="student")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     */
    private $group;
    
    /**
     * @var Time
     * @ORM\ManyToOne(targetEntity="Time", inversedBy="student")
     * @ORM\JoinColumn(name="time_id", referencedColumnName="id", nullable=false)
     */
    private $time;


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
     * Set isCandidate
     *
     * @param boolean $isCandidate
     * @return Student
     */
    public function setIsCandidate($isCandidate)
    {
        $this->isCandidate = $isCandidate;

        return $this;
    }

    /**
     * Get isCandidate
     *
     * @return boolean 
     */
    public function getIsCandidate()
    {
        return $this->isCandidate;
    }
    
    /**
     * Set code
     *
     * @param string $code
     * @return Student
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
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
    
    /**
     * Set picture
     *
     * @param string $picture
     * @return Student
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }
    
    /**
     * Set file
     *
     * @param UploadedFile $file
     * @return Student
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if (isset($this->picture)) {
            $this->temp = $this->picture;
            $this->picture = null;
        } else {
            $this->picture = 'initial';
        }
        return $this;
    }

    /**
     * Get file
     *
     * @return UploadedFile 
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->picture = $filename.'.'.$this->getFile()->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move($this->getUploadRootDir(), $this->picture);
        
        if (isset($this->temp)) {
            unlink($this->getUploadRootDir().'/'.$this->temp);
            $this->temp = null;
        }
        $this->file = null;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }
    
    /**
     * 
     * @return string|null
     */
    public function getAbsolutePath()
    {
        return null === $this->picture
            ? null
            : $this->getUploadRootDir().'/'.$this->picture;
    }
    
    /**
     * The absolute directory path where uploaded
     * documents should be saved.
     * 
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../uploads/'.$this->getUploadDir();
    }

    /**
     * 
     * @return string
     */
    protected function getUploadDir()
    {
        return 'pic/candidates';
    }
    
    /**
     * 
     * @return Grade
     */
    function getGrade() {
        return $this->grade;
    }

    /**
     * 
     * @param Grade $grade
     */
    function setGrade(Grade $grade)
    {
        $this->grade = $grade;
    }
    
    /**
     * 
     * @return Group
     */
    function getGroup()
    {
        return $this->group;
    }

    /**
     * 
     * @return Time
     */
    function getTime()
    {
        return $this->time;
    }

    /**
     * 
     * @param Group $group
     */
    function setGroup(Group $group)
    {
        $this->group = $group;
    }

    /**
     * 
     * @param Time $time
     */
    function setTime(Time $time)
    {
        $this->time = $time;
    }
}
