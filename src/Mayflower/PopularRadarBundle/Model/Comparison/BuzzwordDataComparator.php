<?php

namespace Mayflower\PopularRadarBundle\Model\Comparison;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyStorage;
use Mayflower\PopularRadarBundle\Model\ResultMapping\FailedCompare;

/**
 * BuzzwordDataComparator
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class BuzzwordDataComparator
{
    /**
     * @var Strategy\StrategyInterface[]
     */
    private $strategies;

    /**
     * Constructor
     *
     * @param StrategyStorage $storage
     */
    public function __construct(StrategyStorage $storage)
    {
        $this->strategies = $storage->getStrategies();
    }

    /**
     * Compares two buzzwords
     *
     * @param BuzzwordFormData $data
     *
     * @return \Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword[]
     */
    public function compareBuzzwords(BuzzwordFormData $data)
    {
        $result = array();

        foreach ($this->strategies as $strategy) {
            if (!$strategy->supports($data)) {
                continue;
            }

            try {
                $result[] = $strategy->apply($data);
            } catch (NoResultsException $ex) {
                $errorModel = new FailedCompare();
                $errorModel->setException($ex);
                $errorModel->setDisplayName($strategy->getDisplayAlias());

                $result[] = $errorModel;
            }
        }

        return $result;
    }
}
