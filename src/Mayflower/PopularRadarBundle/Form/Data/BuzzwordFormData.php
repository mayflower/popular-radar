<?php

namespace Mayflower\PopularRadarBundle\Form\Data;

/**
 * BuzzwordFormData
 *
 * Data class which contains the data of the buzzword form
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class BuzzwordFormData
{
    /**
     * @var string
     */
    private $buzzword1;

    /**
     * @var string
     */
    private $buzzword2;

    /**
     * @var bool
     */
    private $githubForks = false;

    /**
     * @var bool
     */
    private $stackoverflowQuestions = false;

    /**
     * @return string
     */
    public function getBuzzword1()
    {
        return $this->buzzword1;
    }

    /**
     * @param string $buzzword1
     */
    public function setBuzzword1($buzzword1)
    {
        $this->buzzword1 = (string) $buzzword1;
    }

    /**
     * @return string
     */
    public function getBuzzword2()
    {
        return $this->buzzword2;
    }

    /**
     * @param string $buzzword2
     */
    public function setBuzzword2($buzzword2)
    {
        $this->buzzword2 = (string) $buzzword2;
    }

    /**
     * @return boolean
     */
    public function isGithubForks()
    {
        return $this->githubForks;
    }

    /**
     * @param boolean $githubForks
     */
    public function setGithubForks($githubForks)
    {
        $this->githubForks = (bool) $githubForks;
    }

    /**
     * @return boolean
     */
    public function isStackoverflowQuestions()
    {
        return $this->stackoverflowQuestions;
    }

    /**
     * @param boolean $stackoverflowQuestions
     */
    public function setStackoverflowQuestions($stackoverflowQuestions)
    {
        $this->stackoverflowQuestions = (bool) $stackoverflowQuestions;
    }
}
