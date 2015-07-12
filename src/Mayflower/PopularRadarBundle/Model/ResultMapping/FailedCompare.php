<?php

namespace Mayflower\PopularRadarBundle\Model\ResultMapping;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;

/**
 * FailedCompare
 *
 * Model which represents a failed buzzword
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class FailedCompare
{
    /**
     * @var NoResultsException
     */
    private $exception;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @return NoResultsException
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param NoResultsException $exception
     *
     * @return $this
     */
    public function setException(NoResultsException $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     *
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }
}
