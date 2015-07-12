<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;

/**
 * AbstractPackagistVoter
 *
 * Abstract voter for packagist voters
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
abstract class AbstractPackagistVoter extends AbstractVoter
{
    /**
     * Searches for a package on packagist
     *
     * @param string $term
     *
     * @return mixed[] mixed
     *
     * @throws NoResultsException If packagist cannot find a package by the given search term
     */
    protected function findPackage($term)
    {
        $client  = $this->getClient();
        $request = $client->createRequest('GET', sprintf('https://packagist.org/search.json?q=%s', $term));

        $response = $client->send($request)->json();
        if ($response['total'] === 0) {
            throw new NoResultsException;
        }

        return $response['results'][0];
    }
}
