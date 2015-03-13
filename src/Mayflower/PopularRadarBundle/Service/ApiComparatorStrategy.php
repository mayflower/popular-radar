<?php

namespace Mayflower\PopularRadarBundle\Service;

use Guzzle\Http\Client;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Service\Strategy\StrategyInterface;

/**
 * ApiComparatorStrategy
 *
 * Service which compares the buzzwords on the configured api
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class ApiComparatorStrategy
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var StrategyInterface[]
     */
    private $strategies = array();

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Pushes a strategy to the strategy stack
     *
     * @param StrategyInterface $strategy
     */
    public function addStrategy(StrategyInterface $strategy)
    {
        $strategy->setHttpClient($this->client);

        $this->strategies[] = $strategy;
    }

    /**
     * @param BuzzwordFormData $formData
     *
     * @return \Mayflower\PopularRadarBundle\Model\Buzzword[]
     */
    public function compareBuzzwords(BuzzwordFormData $formData)
    {
        $result = array();

        foreach ($this->strategies as $strategy) {
            if (!$strategy->supports($formData)) {
                continue;
            }

            $result[] = $strategy->apply($formData);
        }

        return $result;
    }
}
