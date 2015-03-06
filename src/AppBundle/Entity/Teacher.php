<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Teacher
 *
 * @ORM\Table(name="profesor")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Teacher
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
     * @return Teacher
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
     * @return Teacher
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
     * @return Teacher
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
     * @return Teacher
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
     * @return Teacher
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
     * @return Teacher
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
     * Set picture
     *
     * @param string $picture
     * @return Teacher
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
     * @return Teacher
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
}
