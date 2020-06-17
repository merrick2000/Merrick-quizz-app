<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionsRepository")
 */
class Questions
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
     * @ORM\Column(name="correct_answer_id", type="string")
     */
    private $correctAnswerId;

    /**
     * @var string
     *
     * @ORM\Column(name="answers", type="string", length=500)
     */
    private $answers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * Constructor
     * @param array $question
     * @return void
     */
    public function __construct(array $question)
    {
        $this->text = $question["question"];
        $this->answers = $question["answers"];
        $this->correctAnswerId = $question["correct_answer_id"];
        $this->createdAt = $question["created_at"];;
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
     * Set correctAnswerId
     *
     * @param integer $correctAnswerId
     *
     * @return Questions
     */
    public function setCorrectAnswerId($correctAnswerId)
    {
        $this->correctAnswerId = $correctAnswerId;

        return $this;
    }

    /**
     * Get correctAnswerId
     *
     * @return string
     */
    public function getCorrectAnswerId()
    {
        return $this->correctAnswerId;
    }

    /**
     * Set answers
     *
     * @param string $answers
     *
     * @return Questions
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get answers
     *
     * @return string
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Questions
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Questions
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}

