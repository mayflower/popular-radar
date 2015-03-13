<?php

namespace Mayflower\PopularRadarBundle\Service\Strategy;

use Guzzle\Http\Client;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;

/**
 * StrategyInterface
 *
 * Interface which provides methods for an strategy item
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
interface StrategyInterface
{
    /**
     * Checks if the input will be supported
     *
     * @param BuzzwordFormData $formData
     *
     * @return boolean
     */
    public function supports(BuzzwordFormData $formData);

    /**
     * Sets the http client
     *
     * @param Client $client
     */
    public function setHttpClient(Client $client);

    /**
     * Applies the strategy
     *
     * @param BuzzwordFormData $formData
     *
     * @return \Mayflower\PopularRadarBundle\Model\Buzzword
     *
     * @throws \Mayflower\PopularRadarBundle\Exception\NoResultsException If the buzzword cannot be found
     */
    public function apply(BuzzwordFormData $formData);
}
