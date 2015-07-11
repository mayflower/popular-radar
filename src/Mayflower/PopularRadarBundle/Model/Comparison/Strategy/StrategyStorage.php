<?php

namespace Mayflower\PopularRadarBundle\Model\Comparison\Strategy;

/**
 * StrategyStorage
 *
 * A container that stores all api strategies
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class StrategyStorage
{
    /**
     * The strategy list
     *
     * @var StrategyInterface[]
     */
    private $strategies = array();

    /**
     * Adds a new strategy
     *
     * @param StrategyInterface $strategy
     *
     * @return $this
     */
    public function addStrategy(StrategyInterface $strategy)
    {
        foreach ($this->strategies as $known) {
            if ($known->getDisplayAlias() === $strategy->getDisplayAlias()) {
                throw new \InvalidArgumentException(
                    sprintf('There\'s already a strategy named "%s"!', $strategy->getDisplayAlias())
                );
            }
        }

        $this->strategies[] = $strategy;

        return $this;
    }

    /**
     * Returns all strategies
     *
     * @return StrategyInterface[]
     */
    public function getStrategies()
    {
        return $this->strategies;
    }
}
