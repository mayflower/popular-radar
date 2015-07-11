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
     * @var string[]
     */
    private $strategies;

    /**
     * @return string
     */
    public function getBuzzword1()
    {
        return $this->buzzword1;
    }

    /**
     * @param string $buzzword1
     *
     * @return $this
     */
    public function setBuzzword1($buzzword1)
    {
        $this->buzzword1 = $buzzword1;

        return $this;
    }

    /**
     * @return string
     *
     * @return $this
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
        $this->buzzword2 = $buzzword2;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getStrategies()
    {
        return $this->strategies;
    }

    /**
     * @param string[] $strategies
     *
     * @return $this
     */
    public function setStrategies($strategies)
    {
        $this->strategies = $strategies;

        return $this;
    }
}
