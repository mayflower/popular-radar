<?php

namespace Mayflower\PopularRadarBundle\Model;

/**
 * Buzzword
 *
 * Value object containing the data of a buzzword
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class Buzzword
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $countLength;

    /**
     * @var string
     */
    private $resultTypeName;

    /**
     * Constructor
     *
     * @param string $name
     * @param integer $countLength
     * @param string $resultTypeName
     */
    public function __construct($name, $countLength, $resultTypeName)
    {
        $this->name           = (string) $name;
        $this->countLength    = (integer) $countLength;
        $this->resultTypeName = (string) $resultTypeName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getResultTypeName()
    {
        return $this->resultTypeName;
    }

    /**
     * Returns the length of the data
     *
     * @return integer
     */
    public function getCountLength()
    {
        return $this->countLength;
    }

    /**
     * Converts the data to an array
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'name'           => $this->name,
            'totalCount'     => $this->countLength,
            'resultTypeName' => $this->resultTypeName
        );
    }
}
