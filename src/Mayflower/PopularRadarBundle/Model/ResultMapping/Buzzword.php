<?php

namespace Mayflower\PopularRadarBundle\Model\ResultMapping;

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
     * @var string
     */
    private $displayName;

    /**
     * Constructor
     *
     * @param string $name
     * @param integer $countLength
     * @param string $resultTypeName
     * @param string $displayName
     */
    public function __construct($name, $countLength, $resultTypeName, $displayName)
    {
        $this->name           = (string) $name;
        $this->countLength    = (integer) $countLength;
        $this->resultTypeName = (string) $resultTypeName;
        $this->displayName    = (string) $displayName;
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
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
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
            'resultTypeName' => $this->resultTypeName,
            'displayName'    => $this->displayName
        );
    }
}
