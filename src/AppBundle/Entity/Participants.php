<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Participants
 *
 * @ORM\Table(name="participants")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParticipantsRepository")
 */
class Participants
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank(message="Enter your username to register your answers.")
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @var date
     *
     * @ORM\Column(name="saved_at", type="datetime")
     */
    private $savedAt;

    /**
     * Constructor
     * @param array $participant
     * @return void
     */
    public function __construct(array $participant)
    {
        $this->username = htmlentities($participant["username"]);
        $this->score = htmlentities($participant["score"]);
        $this->savedAt = new \DateTime();
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;

        //return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Participants
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set savedAt
     *
     * @param date $savedAt
     *
     * @return Participants
     */
    public function setSavedAt($savedAt)
    {
        $this->savedAt = $savedAt;

        return $this;
    }

    /**
     * Get savedAt
     *
     * @return date
     */
    public function getSavedAt()
    {
        return $this->savedAt;
    }
}

